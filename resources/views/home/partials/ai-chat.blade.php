@php use Illuminate\Support\Facades\Auth; @endphp
<div class="ai-chat-window" id="ai-chat-window" style="display:none;width:480px;max-width:98vw;height:420px;">
    <div class="ai-chat-header">
        Кибер-бот 🤖
        <span class="ai-chat-close" title="Закрыть">×</span>
        @if(Auth::check() && Auth::user())
            <span style="margin-left:18px;color:#00fff7;font-size:1em;">Вы вошли как <b>{{ Auth::user()->name ?: Auth::user()->email }}</b></span>
        @endif
    </div>
    @if(Auth::check() && Auth::user())
        <button id="logout-btn-modal" type="button" class="cyber-btn" style="position:absolute;top:12px;right:18px;z-index:10;padding:4px 12px;font-size:0.9em;background:#111a22;color:#ff00cc;border:1px solid #ff00cc;border-radius:6px;cursor:pointer;">Выйти</button>
    @endif
    <div class="ai-chat-history" id="ai-chat-history-modal" style="height:340px;overflow-y:auto;max-height:340px;"></div>
    <form class="ai-chat-form" id="ai-chat-form-modal">
        <input type="text" id="ai-chat-input-modal" placeholder="Введите вопрос..." autocomplete="off" required />
        <button type="submit">Отправить</button>
    </form>
    @if(!Auth::check())
        <div style="padding:12px 18px;text-align:center;">
            <button class="cyber-btn" onclick="window.location.href='/register'">Регистрация</button>
            <button class="cyber-btn" onclick="window.location.href='/login'">Вход</button>
        </div>
    @endif
</div>
