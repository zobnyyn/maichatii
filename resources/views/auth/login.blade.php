<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/cyberpunk.css">
</head>
<body>
    <div class="main-content-wrapper">
        <div class="cyber-card">
            <h1>Вход</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div style="margin-bottom:18px;">
                    <label for="email">Email:</label><br>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}">
                </div>
                <div style="margin-bottom:18px;">
                    <label for="password">Пароль:</label><br>
                    <input type="password" name="password" id="password" required>
                </div>
                <div style="margin-bottom:18px;">
                    <label><input type="checkbox" name="remember"> Запомнить меня</label>
                </div>
                <button class="cyber-btn" type="submit">Войти</button>
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

