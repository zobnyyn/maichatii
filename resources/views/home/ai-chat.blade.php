@php use Illuminate\Support\Facades\Auth; @endphp
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="/css/chat.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header class="main-header">
        <div class="main-header-inner">
            <div class="main-header-title">
                <a href="/">Mai-Senpai ^_^</a>
            </div>
            <div class="main-header-actions">
                <button id="debug-toggle">Debug</button>
                <button id="history-toggle">История диалога</button>
                @if(Auth::check())
                    <span class="main-header-user">
                        Вы вошли как <b>{{ Auth::user()->name ?? Auth::user()->email }}</b>
                    </span>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline-flex;align-items:center;margin:0;">
                        @csrf
                        <button type="submit">Выйти</button>
                    </form>
                @else
                    <span class="main-header-notauth">Вы не авторизованы</span>
                    <button id="register-toggle">Регистрация</button>
                    <button id="login-toggle">Вход</button>
                @endif
            </div>
        </div>
    </header>
    <div class="fullpage-chat">
        <div class="chat-history" id="ai-chat-history">
            @foreach($history as $msg)
                <div class="chat-msg user"><span class="chat-text">{{ $msg->user_message }}</span></div>
                @if($msg->bot_answer)
                    <div class="chat-msg bot">
                        <img src="/images/avatar.jpg" class="chat-avatar" alt="Аватарка бота">
                        <span class="chat-text">{{ $msg->bot_answer }}</span>
                    </div>
                @endif
            @endforeach
        </div>
        <form class="chat-form" id="ai-chat-form-main">
            <div class="chat-form-inner">
                <input type="text" id="ai-chat-input" placeholder="Введите вопрос..." autocomplete="off" required class="chat-form-input" />
                <button type="submit" aria-label="Отправить" class="chat-form-btn"></button>
            </div>
            <div class="chat-bottom-footer">Чат с Mai-Senpai</div>
        </form>
        <div id="debug-panel">
            <b>Debug:</b>
            <pre id="debug-content"></pre>
        </div>
        <div id="history-modal">
            <div class="history-modal-inner">
                <div class="history-modal-title">Вся история диалога</div>
                <button id="history-close" class="history-modal-close">×</button>
                <div id="history-list" class="history-modal-list">
                    @php
                        $userId = Auth::id();
                        if ($userId) {
                            $historyList = \App\Models\ChatMessage::where('user_id', $userId)->orderBy('created_at','asc')->get();
                        } else {
                            $historyList = \App\Models\ChatMessage::whereNull('user_id')->orderBy('created_at','asc')->get();
                        }
                    @endphp
                    @foreach($historyList as $msg)
                        <div class="history-list-item">
                            <div class="history-list-user">Вы:</div>
                            <div class="history-list-user-msg">{{ $msg->user_message }}</div>
                            @if($msg->bot_answer)
                                <div class="history-list-bot">Бот:</div>
                                <div class="history-list-bot-msg">{{ $msg->bot_answer }}</div>
                            @endif
                            <div class="history-list-date">{{ $msg->created_at }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div id="register-modal">
            <div class="register-modal-inner">
                <div class="register-modal-title">Регистрация</div>
                <button id="register-close" class="register-modal-close">×</button>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="register-modal-field">
                        <label for="reg-name">Имя:</label><br>
                        <input type="text" name="name" id="reg-name" required value="{{ old('name') }}">
                    </div>
                    <div class="register-modal-field">
                        <label for="reg-email">Email:</label><br>
                        <input type="email" name="email" id="reg-email" required value="{{ old('email') }}">
                    </div>
                    <div class="register-modal-field">
                        <label for="reg-password">Пароль:</label><br>
                        <input type="password" name="password" id="reg-password" required>
                        <div class="register-modal-hint">Пароль должен быть не менее 6 символов</div>
                    </div>
                    <div class="register-modal-field">
                        <label for="reg-password_confirmation">Повторите пароль:</label><br>
                        <input type="password" name="password_confirmation" id="reg-password_confirmation" required>
                    </div>
                    <button class="register-modal-btn">Зарегистрироваться</button>
                </form>
                @if ($errors->any())
                    <div class="register-modal-errors">
                        <b>Ошибки регистрации:</b>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div id="login-modal">
            <div class="login-modal-inner">
                <div class="login-modal-title">Вход</div>
                <button id="login-close" class="login-modal-close">×</button>
                <form method="POST" action="{{ route('login') }}" id="login-form">
                    @csrf
                    <div class="login-modal-field">
                        <label for="login-email">Email:</label><br>
                        <input type="email" name="email" id="login-email" required value="{{ old('email') }}">
                    </div>
                    <div class="login-modal-field">
                        <label for="login-password">Пароль:</label><br>
                        <input type="password" name="password" id="login-password" required>
                        <div class="login-modal-hint">Пароль должен быть не менее 6 символов</div>
                    </div>
                    <div class="login-modal-field">
                        <label><input type="checkbox" name="remember"> Запомнить меня</label>
                    </div>
                    <button class="login-modal-btn">Войти</button>
                </form>
                @if ($errors->any())
                    <div class="login-modal-errors">
                        <b>Ошибки входа:</b>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <div class="login-modal-hint">
                            Проверьте правильность email и пароля. Если забыли пароль, зарегистрируйте новый аккаунт.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- @include('home.partials.footer') -->
    <script src="/js/chat.js"></script>
</body>
</html>
