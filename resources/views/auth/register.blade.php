<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/cyberpunk.css">
</head>
<body>
    <div class="main-content-wrapper">
        <div class="cyber-card">
            <h1>Регистрация</h1>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div style="margin-bottom:18px;">
                    <label for="name">Имя:</label><br>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}">
                </div>
                <div style="margin-bottom:18px;">
                    <label for="email">Email:</label><br>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}">
                </div>
                <div style="margin-bottom:18px;">
                    <label for="password">Пароль:</label><br>
                    <input type="password" name="password" id="password" required>
                </div>
                <div style="margin-bottom:18px;">
                    <label for="password_confirmation">Повторите пароль:</label><br>
                    <input type="password" name="password_confirmation" id="password_confirmation" required>
                </div>
                <button class="cyber-btn" type="submit">Зарегистрироваться</button>
            </form>
            @if ($errors->any())
                <div style="color:#ff00cc;margin-top:18px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</body>
</html>

