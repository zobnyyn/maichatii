<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/cyberpunk.css">
    <script type="module" src="/js/app.js"></script>
    <script type="module" src="/js/cyberpunk.js"></script>
</head>
<body>
    <div class="main-content-wrapper">
        @include('home.partials.header')
        <div class="neon-lines">
            <div class="neon-line" style="left: 10vw;"></div>
            <div class="neon-line" style="left: 30vw;"></div>
            <div class="neon-line" style="left: 50vw;"></div>
            <div class="neon-line" style="left: 70vw;"></div>
            <div class="neon-line" style="left: 90vw;"></div>
        </div>
        <div class="cyber-card hologram-card" id="holoCard">
            <div class="emoji">🤖</div>
            <!-- Заголовок теперь в header -->
            @isset($users)
            <h1>Пользователи:</h1>
            @foreach($users as $user)
                <pre>{{ print_r($user, true) }}</pre>
            @endforeach
            @endisset
            <p>Это твой первый Laravel-проект в Docker!<br>Удачи в разработке! <span style="color:#ff00cc;">⚡</span></p>
            <button class="cyber-btn" onclick="window.location.href='/'">На главную</button>
            <button class="cyber-btn" onclick="window.location.href='/test'">Test</button>
            <button class="cyber-btn destroy-btn" id="destroyBtn">Разрушить</button>
            <div class="holo-glow"></div>
        </div>
    </div>
    <div id="ai-avatar" class="ai-avatar" title="Кликни для подсказки!"></div>
    @include('home.partials.ai-chat')
    <div class="cyberpunk-city-bg">
        <svg viewBox="0 0 1920 700" width="100vw" height="700" style="position:fixed;left:0;bottom:0;width:100vw;height:700px;z-index:0;pointer-events:none;display:block;" preserveAspectRatio="none">
            <g>
                <rect x="0" y="620" width="1920" height="80" fill="#111a22" />
                <!-- Здания (увеличены по высоте и добавлены новые) -->
                <rect x="60" y="280" width="180" height="420" fill="#222a44" />
                <rect x="280" y="400" width="120" height="300" fill="#1a1f2f" />
                <rect x="440" y="320" width="160" height="380" fill="#222a44" />
                <rect x="630" y="480" width="90" height="220" fill="#1a1f2f" />
                <rect x="750" y="340" width="140" height="360" fill="#222a44" />
                <rect x="920" y="420" width="110" height="280" fill="#1a1f2f" />
                <rect x="1060" y="270" width="180" height="430" fill="#222a44" />
                <rect x="1260" y="370" width="120" height="330" fill="#1a1f2f" />
                <rect x="1400" y="480" width="90" height="220" fill="#222a44" />
                <rect x="1500" y="340" width="140" height="360" fill="#1a1f2f" />
                <rect x="1670" y="420" width="110" height="280" fill="#222a44" />
                <!-- Неоновые вывески -->
                <rect class="city-neon-sign" x="120" y="320" width="80" height="22" rx="8" fill="#00fff7" />
                <rect class="city-neon-sign" x="480" y="370" width="60" height="18" rx="6" fill="#ff00cc" />
                <rect class="city-neon-sign" x="800" y="340" width="90" height="26" rx="10" fill="#00fff7" />
                <rect class="city-neon-sign" x="1100" y="320" width="80" height="22" rx="8" fill="#ff00cc" />
                <rect class="city-neon-sign" x="1550" y="370" width="60" height="18" rx="6" fill="#00fff7" />
                <!-- Мигающие окна -->
                <rect class="city-window" x="100" y="500" width="16" height="32" fill="#00fff7" />
                <rect class="city-window" x="160" y="500" width="16" height="32" fill="#ff00cc" />
                <rect class="city-window" x="500" y="600" width="14" height="24" fill="#00fff7" />
                <rect class="city-window" x="540" y="600" width="14" height="24" fill="#ff00cc" />
                <rect class="city-window" x="820" y="600" width="14" height="24" fill="#00fff7" />
                <rect class="city-window" x="860" y="600" width="14" height="24" fill="#ff00cc" />
                <rect class="city-window" x="1120" y="600" width="14" height="24" fill="#00fff7" />
                <rect class="city-window" x="1160" y="600" width="14" height="24" fill="#ff00cc" />
                <rect class="city-window" x="1570" y="600" width="14" height="24" fill="#00fff7" />
                <rect class="city-window" x="1610" y="600" width="14" height="24" fill="#ff00cc" />
            </g>
        </svg>
    </div> <!-- Добавлен фон города -->
    @include('home.partials.footer')
</body>
</html>
