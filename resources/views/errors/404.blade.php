<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Страница не найдена</title>
    <style>
        body {
            background: linear-gradient(120deg, #f857a6 0%, #ff5858 100%);
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: rgba(255,255,255,0.95);
            border-radius: 24px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.25);
            padding: 48px 60px;
            text-align: center;
            max-width: 420px;
        }
        .emoji {
            font-size: 5rem;
            margin-bottom: 18px;
        }
        h1 {
            margin: 0 0 10px 0;
            font-size: 2.5rem;
            color: #d72660;
        }
        p {
            color: #4a6073;
            font-size: 1.15rem;
        }
        a.btn {
            display: inline-block;
            margin-top: 28px;
            padding: 12px 32px;
            background: #f857a6;
            color: #fff;
            border: none;
            border-radius: 30px;
            font-size: 1.1rem;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
        }
        a.btn:hover {
            background: #ff5858;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="emoji">😕🔍</div>
        <h1>404 — Не найдено</h1>
        <p>Упс! Такой страницы не существует.<br>Возможно, вы ошиблись адресом или страница была удалена.</p>
        <a href="/" class="btn">На главную</a>
    </div>
</body>
</html>

