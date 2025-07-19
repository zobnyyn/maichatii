<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
        }
        .container {
            background: rgba(255,255,255,0.97);
            border-radius: 24px;
            box-shadow: 0 8px 40px rgba(30,60,114,0.2);
            padding: 48px 64px 40px 64px;
            text-align: center;
            position: relative;
            z-index: 2;
        }
        h2 {
            color: #1e3c72;
            font-size: 2.5em;
            margin-bottom: 0.2em;
        }
        p {
            color: #444;
            font-size: 1.3em;
            margin-bottom: 1.5em;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0 0 1.5em 0;
        }
        ul li {
            background: #e3eaff;
            color: #1e3c72;
            margin: 8px 0;
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 1.1em;
            box-shadow: 0 2px 8px rgba(30,60,114,0.07);
            transition: transform 0.2s;
        }
        ul li:hover {
            transform: scale(1.05) rotate(-2deg);
            background: #b6cfff;
        }
        .firework {
            position: absolute;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #fff;
            animation: firework 1.2s linear infinite;
            opacity: 0.7;
        }
        @keyframes firework {
            0% { transform: scale(0.5) translateY(0); opacity: 0.7; }
            60% { opacity: 1; }
            100% { transform: scale(1.5) translateY(-180px); opacity: 0; }
        }
        .emoji {
            font-size: 3.5em;
            margin-bottom: 0.2em;
            animation: bounce 1.2s infinite alternate;
        }
        @keyframes bounce {
            0% { transform: translateY(0); }
            100% { transform: translateY(-18px); }
        }
        .glow {
            text-shadow: 0 0 12px #2a5298, 0 0 24px #1e3c72;
        }
        .neon {
            color: #fff;
            text-shadow: 0 0 8px #00e6ff, 0 0 16px #00e6ff, 0 0 32px #00e6ff;
            font-size: 1.2em;
            letter-spacing: 2px;
            margin-bottom: 1em;
        }
        .confetti {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            pointer-events: none;
            z-index: 10;
        }
    </style>
</head>
<body>
    <!-- Фейерверки -->
    <div class="firework" style="left: 20%; animation-delay: 0s; background: #ffb347;"></div>
    <div class="firework" style="left: 40%; animation-delay: 0.3s; background: #ff5e62;"></div>
    <div class="firework" style="left: 60%; animation-delay: 0.6s; background: #76e2ff;"></div>
    <div class="firework" style="left: 80%; animation-delay: 0.9s; background: #baffc9;"></div>
    <!-- Контейнер с контентом -->
    <div class="container">
        <div class="emoji glow">🤩</div>
        <h2 class="glow">Вау! Ты это видишь?</h2>
        <div class="neon">Это не просто HTML — это магия современного веба!</div>
        <p>Смотри, как всё сияет и анимируется ✨</p>
        <h3>Список удивительных данных:</h3>
        <ul>
            <li>{{$name}}— имя</li>
            <li>{{$age}}— возраст</li>
        </ul>
        <p style="font-size:1.1em; color:#1e3c72;">Пусть твой проект будет таким же ярким и крутым!</p>
    </div>
    <!-- Конфетти -->
    <canvas class="confetti"></canvas>
    <script>
    // Конфетти-анимация
    const canvas = document.querySelector('.confetti');
    const ctx = canvas.getContext('2d');
    let W = window.innerWidth, H = window.innerHeight;
    canvas.width = W; canvas.height = H;
    let confetti = [];
    for(let i=0;i<150;i++){
        confetti.push({
            x: Math.random()*W,
            y: Math.random()*H,
            r: Math.random()*6+4,
            d: Math.random()*150+50,
            color: `hsl(${Math.random()*360},90%,60%)`,
            tilt: Math.random()*10-10
        });
    }
    function drawConfetti(){
        ctx.clearRect(0,0,W,H);
        confetti.forEach(c=>{
            ctx.beginPath();
            ctx.arc(c.x,c.y,c.r,0,2*Math.PI);
            ctx.fillStyle=c.color;
            ctx.fill();
        });
        updateConfetti();
    }
    function updateConfetti(){
        confetti.forEach(c=>{
            c.y += Math.cos(c.d)+2+c.r/2;
            c.x += Math.sin(c.d);
            if(c.y>H){c.y=-10; c.x=Math.random()*W;}
        });
    }
    setInterval(drawConfetti,16);
    window.addEventListener('resize',()=>{
        W=window.innerWidth; H=window.innerHeight;
        canvas.width=W; canvas.height=H;
    });
    </script>
</body>
</html>

