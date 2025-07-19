// Киберпанк-эффекты: неоновый фон, курсор, голограмма, звук, вспышка

document.addEventListener('DOMContentLoaded', function() {
    const audio = new Audio('/sounds/najatie-na-kompyuternuyu-knopku1.mp3');
    audio.onerror = () => {
        // Ошибка загрузки аудиофайла для кнопки
    };
    document.querySelectorAll('.cyber-btn').forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            audio.currentTime = 0;
            audio.play();
        });
    });
});

// Голографический эффект для карточки
document.addEventListener('DOMContentLoaded', function() {
    const card = document.getElementById('holoCard');
    if (!card) return;
    const glow = card.querySelector('.holo-glow');
    card.style.perspective = '1200px';
    card.style.transformStyle = 'preserve-3d';
    card.addEventListener('mousemove', function(e) {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const rotateX = -(y - centerY) / 18;
        const rotateY = (x - centerX) / 18;
        card.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        glow.style.background = `radial-gradient(circle at ${x}px ${y}px, #00fff7 0%, #ff00cc 80%, transparent 100%)`;
        glow.style.opacity = '0.35';
    });
    card.addEventListener('mouseleave', function() {
        card.style.transform = 'rotateX(0deg) rotateY(0deg)';
        glow.style.opacity = '0';
    });
});

// Глитч-эффект для кнопок и заголовка
function addGlitchEffect(el) {
    if (!el) return;
    el.setAttribute('data-text', el.textContent);
    el.classList.add('glitch-effect');
    setTimeout(() => el.classList.remove('glitch-effect'), 350);
}
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.cyber-btn').forEach(btn => {
        btn.addEventListener('mouseenter', () => addGlitchEffect(btn));
    });
    const h1 = document.querySelector('.cyber-card h1');
    if (h1) {
        h1.addEventListener('mouseenter', () => addGlitchEffect(h1));
    }
});

// --- Destroyer effect ---
function destroyEffect() {
    const card = document.getElementById('holoCard');
    if (!card) { console.error('destroyEffect: holoCard не найден'); return; }
    const rect = card.getBoundingClientRect();
    const scale = window.devicePixelRatio || 1;
    // Создаём canvas поверх всего
    let canvas = document.getElementById('destroy-canvas');
    if (!canvas) {
        canvas = document.createElement('canvas');
        canvas.id = 'destroy-canvas';
        canvas.style.position = 'fixed';
        canvas.style.left = '0';
        canvas.style.top = '0';
        canvas.style.zIndex = '99999';
        canvas.style.pointerEvents = 'none';
        document.body.appendChild(canvas);
        console.log('destroyEffect: destroy-canvas создан');
    }
    canvas.width = window.innerWidth * scale;
    canvas.height = window.innerHeight * scale;
    canvas.style.width = '100vw';
    canvas.style.height = '100vh';
    const ctx = canvas.getContext('2d');
    ctx.setTransform(scale, 0, 0, scale, 0, 0);
    console.log('destroyEffect: запускаем html2canvas');
    // Делаем скриншот карточки
    html2canvas(card, {backgroundColor: null, scale: scale}).then(cardCanvas => {
        console.log('destroyEffect: html2canvas завершил, начинаем анимацию');
        card.style.visibility = 'hidden';
        // Разбиваем на фрагменты
        const fragSize = 32;
        const frags = [];
        for (let y = 0; y < cardCanvas.height; y += fragSize) {
            for (let x = 0; x < cardCanvas.width; x += fragSize) {
                const w = Math.min(fragSize, cardCanvas.width - x);
                const h = Math.min(fragSize, cardCanvas.height - y);
                const imageData = cardCanvas.getContext('2d').getImageData(x, y, w, h);
                // x и y теперь относительно центра карточки на экране
                frags.push({
                    x: rect.left + x,
                    y: rect.top + y,
                    w, h,
                    dx: (Math.random() - 0.5) * 16,
                    dy: (Math.random() - 0.5) * 16,
                    vx: (Math.random() - 0.5) * 16,
                    vy: (Math.random() - 0.5) * 16,
                    a: 1,
                    imageData
                });
            }
        }
        let frame = 0;
        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            for (const f of frags) {
                ctx.save();
                ctx.globalAlpha = f.a;
                ctx.shadowColor = '#00fff7';
                ctx.shadowBlur = 16;
                ctx.putImageData(f.imageData, f.x, f.y);
                ctx.restore();
                f.x += f.vx;
                f.y += f.vy;
                f.vy += 0.7 + Math.random() * 0.2;
                f.vx += (Math.random() - 0.5) * 0.5;
                f.a -= 0.012 + Math.random() * 0.01;
            }
            frame++;
            if (frame < 80) {
                requestAnimationFrame(animate);
            } else {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                canvas.remove();
                card.style.visibility = 'visible';
                card.innerHTML = '<div class="emoji">💥</div><h2 style="color:#ff00cc;">КАРТОЧКА РАЗРУШЕНА!</h2><p style="color:#00fff7;">Обнови страницу, чтобы восстановить.</p>';
                showAchievementToast({emoji: '💥', text: 'Ачивка: Кибер-разрушитель!'});
                console.log('destroyEffect: анимация завершена');
            }
        }
        animate();
    }).catch(err => {
        console.error('destroyEffect: html2canvas ошибка', err);
    });
}
// html2canvas подключается динамически
function loadHtml2CanvasAndRun(cb) {
    if (window.html2canvas) return cb();
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js';
    script.onload = cb;
    document.head.appendChild(script);
}
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('destroyBtn');
    if (btn) {
        btn.addEventListener('click', function() {
            loadHtml2CanvasAndRun(destroyEffect);
        });
    }
});

// --- Achievement Toast --- вырезано, но функционал есть
function showAchievementToast({emoji = '🏆', text = 'Достижение!', timeout = 3500} = {}) {
    // Удалить предыдущий тост, если есть
    const old = document.querySelector('.achievement-toast');
    if (old) old.remove();
    const toast = document.createElement('div');
    toast.className = 'achievement-toast';
    toast.innerHTML = `<span class="achv-emoji">${emoji}</span><span>${text}</span>`;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.animation = 'toast-out 0.5s forwards';
        setTimeout(() => toast.remove(), 500);
    }, timeout);
}

// --- RED ALERT MODE --- выреазно, но функционал есть
(function() {
    let redAlertActive = false;
    let redAlertAudio = null;
    let redAlertFlashInterval = null;
    let redAlertGlitchInterval = null;
    function playRedAlertSiren() {
        if (redAlertAudio) return;
        redAlertAudio = new Audio('https://cdn.pixabay.com/audio/2022/10/16/audio_12b7b7b2b2.mp3'); // Можно заменить на сирену
        redAlertAudio.loop = true;
        redAlertAudio.volume = 0.5;
        redAlertAudio.play();
    }
    function stopRedAlertSiren() {
        if (redAlertAudio) {
            redAlertAudio.pause();
            redAlertAudio = null;
        }
    }
    function redAlertFlash() {
        const flash = document.createElement('div');
        flash.className = 'red-alert-flash';
        document.body.appendChild(flash);
        setTimeout(() => flash.remove(), 350);
    }
    function redAlertGlitchAll() {
        document.querySelectorAll('.cyber-btn, h1, .logo-glitch, .glitch').forEach(el => {
            el.setAttribute('data-text', el.textContent);
            el.classList.add('glitch-effect');
            setTimeout(() => el.classList.remove('glitch-effect'), 350);
        });
    }
    function activateRedAlert() {
        if (redAlertActive) return;
        redAlertActive = true;
        document.body.classList.add('red-alert');
        playRedAlertSiren();
        redAlertFlash();
        redAlertGlitchAll();
        redAlertFlashInterval = setInterval(redAlertFlash, 1200);
        redAlertGlitchInterval = setInterval(redAlertGlitchAll, 900);
    }
    function deactivateRedAlert() {
        if (!redAlertActive) return;
        redAlertActive = false;
        document.body.classList.remove('red-alert');
        stopRedAlertSiren();
        if (redAlertFlashInterval) clearInterval(redAlertFlashInterval);
        if (redAlertGlitchInterval) clearInterval(redAlertGlitchInterval);
    }
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.altKey && e.code === 'KeyR') {
            if (!redAlertActive) {
                activateRedAlert();
            } else {
                deactivateRedAlert();
            }
        }
    });
})();

// --- MATRIX RAIN EFFECT ---
(function() {
    let matrixRainActive = false;
    let matrixCanvas = null;
    let matrixCtx = null;
    let matrixColumns = [];
    let matrixFontSize = 18;
    let matrixChars = 'アァカサタナハマヤャラワガザダバパイィキシチニヒミリヰギジヂビピウゥクスツヌフムユュルグズヅブプエェケセテネヘメレヱゲゼデベペオォコソトノホモヨョロヲゴゾドボポヴッンABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let matrixAnimationId = null;

    function resizeMatrix() {
        if (!matrixCanvas) return;
        matrixCanvas.width = window.innerWidth;
        matrixCanvas.height = window.innerHeight;
        let columns = Math.floor(window.innerWidth / matrixFontSize);
        matrixColumns = [];
        for (let i = 0; i < columns; i++) {
            matrixColumns[i] = Math.random() * window.innerHeight / matrixFontSize | 0;
        }
    }

    function drawMatrix() {
        if (!matrixCtx) return;
        matrixCtx.fillStyle = 'rgba(0, 0, 0, 0.18)';
        matrixCtx.fillRect(0, 0, matrixCanvas.width, matrixCanvas.height);
        matrixCtx.font = matrixFontSize + 'px monospace';
        for (let i = 0; i < matrixColumns.length; i++) {
            let char = matrixChars[Math.floor(Math.random() * matrixChars.length)];
            let x = i * matrixFontSize;
            let y = matrixColumns[i] * matrixFontSize;
            matrixCtx.fillStyle = '#00ff66';
            matrixCtx.shadowColor = '#00ffcc';
            matrixCtx.shadowBlur = 12;
            matrixCtx.fillText(char, x, y);
            if (y > matrixCanvas.height && Math.random() > 0.975) {
                matrixColumns[i] = 0;
            } else {
                matrixColumns[i]++;
            }
        }
        matrixAnimationId = requestAnimationFrame(drawMatrix);
    }

    function activateMatrixRain() {
        if (matrixRainActive) return;
        matrixRainActive = true;
        document.body.classList.add('matrix-rain-active');
        if (!matrixCanvas) {
            matrixCanvas = document.createElement('canvas');
            matrixCanvas.className = 'matrix-rain-canvas';
            document.body.appendChild(matrixCanvas);
            matrixCtx = matrixCanvas.getContext('2d');
            window.addEventListener('resize', resizeMatrix);
        }
        resizeMatrix();
        drawMatrix();
    }
    function deactivateMatrixRain() {
        if (!matrixRainActive) return;
        matrixRainActive = false;
        document.body.classList.remove('matrix-rain-active');
        if (matrixAnimationId) cancelAnimationFrame(matrixAnimationId);
        if (matrixCtx) matrixCtx.clearRect(0, 0, matrixCanvas.width, matrixCanvas.height);
    }
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.altKey && e.code === 'KeyM') {
            if (!matrixRainActive) {
                activateMatrixRain();
            } else {
                deactivateMatrixRain();
            }
        }
    });
})();

// --- AI AVATAR + GPT CHAT ---
document.addEventListener('DOMContentLoaded', function() {
    const avatar = document.getElementById('ai-avatar');
    if (!avatar) return;
    // Вставляем лицо
    avatar.innerHTML = `
      <div class="ai-avatar-face">
        <div class="ai-avatar-eye left"></div>
        <div class="ai-avatar-eye right"></div>
        <div class="ai-avatar-mouth"></div>
      </div>
      <div class="ai-avatar-tooltip" id="ai-avatar-tooltip"></div>
    `;
    const leftEye = avatar.querySelector('.ai-avatar-eye.left');
    const rightEye = avatar.querySelector('.ai-avatar-eye.right');
    const tooltip = avatar.querySelector('.ai-avatar-tooltip');
    // Фразы для подсказок
    const tips = [
      'Привет! Я твой кибер-ассистент 🤖',
      'Нажми Ctrl+Alt+R для тревоги!',
      'Включи дождь Матрицы: Ctrl+Alt+M',
      'Наведи на кнопки — будет звук!',
      'Я могу подмигнуть 😉',
      'Разрушь карточку — получи ачивку!',
      'Кликни по мне для подсказки!'
    ];
    let tipIndex = 0;
    function showTip(text) {
      tooltip.textContent = text;
      tooltip.classList.add('active');
      setTimeout(() => tooltip.classList.remove('active'), 3500);
    }
    // Мигание
    setInterval(() => {
      leftEye.classList.add('ai-avatar-blink');
      rightEye.classList.add('ai-avatar-blink');
      setTimeout(() => {
        leftEye.classList.remove('ai-avatar-blink');
        rightEye.classList.remove('ai-avatar-blink');
      }, 180);
    }, 4000 + Math.random()*2000);
    // Подмигивание при наведении
    avatar.addEventListener('mouseenter', () => {
      avatar.classList.add('ai-avatar-wink');
      setTimeout(() => avatar.classList.remove('ai-avatar-wink'), 400);
    });
    // --- CHAT LOGIC ---
    const chatWindow = document.getElementById('ai-chat-window');
    const chatHistory = document.getElementById('ai-chat-history');
    const chatForm = document.getElementById('ai-chat-form');
    const chatInput = document.getElementById('ai-chat-input');
    const chatClose = document.querySelector('.ai-chat-close');
    let chatOpen = false;
    avatar.addEventListener('click', function(e) {
      // Открыть чат, если не по подсказке
      if (e.target.classList.contains('ai-avatar-face') || e.target === avatar) {
        chatWindow.style.display = 'block';
        chatOpen = true;
        chatInput.focus();
      }
    });
    chatClose.addEventListener('click', function() {
      chatWindow.style.display = 'none';
      chatOpen = false;
    });
    chatForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const msg = chatInput.value.trim();
      if (!msg) return;
      appendMessage('user', msg);
      chatInput.value = '';
      chatInput.disabled = true;
      sendToGpt(msg);
    });
    function appendMessage(role, text) {
      const div = document.createElement('div');
      div.className = 'ai-chat-msg ' + role;
      div.innerHTML = `<span>${role === 'user' ? 'Вы' : 'Бот'}:</span> ${text}`;
      chatHistory.appendChild(div);
      chatHistory.scrollTop = chatHistory.scrollHeight;
    }
    function sendToGpt(msg) {
      fetch('/api/nvidia-chat', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
        },
        body: JSON.stringify({message: msg})
      })
      .then(r => r.json())
      .then(data => {
        if (data.answer) {
          appendMessage('bot', data.answer);
        } else if (data.error) {
          let errorText = 'Ошибка: ' + data.error;
          if (data.details) {
            errorText += '<br><span style="color:#ff00cc;font-size:0.95em;">' + data.details + '</span>';
          }
          appendMessage('bot', errorText);
        } else {
          appendMessage('bot', 'Нет ответа');
        }
      })
      .catch(() => {
        appendMessage('bot', 'Ошибка соединения с сервером');
      })
      .finally(() => {
        chatInput.disabled = false;
        chatInput.focus();
      });
    }
    // Показ подсказки при клике
    avatar.addEventListener('click', () => {
      tipIndex = (tipIndex + 1) % tips.length;
      showTip(tips[tipIndex]);
    });
    // Приветствие при загрузке
    setTimeout(() => showTip(tips[0]), 800);
    // --- LOGIN FORM AJAX ---
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Удаляем старые ошибки
            loginForm.querySelectorAll('.login-error-msg').forEach(el => el.remove());
            const formData = new FormData(loginForm);
            // Добавляем CSRF-токен вручную, если он есть в форме
            const csrfInput = loginForm.querySelector('input[name="_token"]');
            if (csrfInput) {
                formData.append('_token', csrfInput.value);
            }
            fetch(loginForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
                credentials: 'same-origin', // обязательно для передачи cookies
            })
            .then(async response => {
                if (response.ok) {
                    window.location.reload();
                } else {
                    const data = await response.json();
                    let errorHtml = '<div class="login-error-msg" style="color:#ff00cc;margin-top:18px;"><b>Ошибки входа:</b><ul>';
                    if (data.errors) {
                        Object.values(data.errors).forEach(arr => {
                            arr.forEach(error => {
                                errorHtml += `<li>${error}</li>`;
                            });
                        });
                    } else if (data.message) {
                        errorHtml += `<li>${data.message}</li>`;
                    }
                    errorHtml += '</ul></div>';
                    loginForm.insertAdjacentHTML('beforeend', errorHtml);
                }
            })
            .catch(() => {
                loginForm.insertAdjacentHTML('beforeend', '<div class="login-error-msg" style="color:#ff00cc;margin-top:18px;">Ошибка соединения с сервером</div>');
            });
        });
    }
});

// --- HOLOGRAPHIC PROJECTION EFFECT ---
(function() {
    const messages = [
        'Добро пожаловать в будущее! 🚀',
        'Киберпанк активирован. Неон — это стиль жизни.',
        'Ваша система защищена ИИ.',
        'Взлом невозможен. Всё под контролем.',
        'Пользователь, ты выглядишь круто сегодня!'
    ];
    let lastIndex = -1;
    function showHoloProjection(msg) {
        const projection = document.createElement('div');
        projection.className = 'holo-projection';
        projection.innerHTML = `<span>${msg}</span><div class='holo-projection-glow'></div>`;
        document.body.appendChild(projection);
        setTimeout(() => projection.remove(), 4000);
    }
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.altKey && e.code === 'KeyH') {
            let idx;
            do { idx = Math.floor(Math.random() * messages.length); } while (idx === lastIndex);
            lastIndex = idx;
            showHoloProjection(messages[idx]);
        }
    });
})();

// --- 3D HOLOGRAM FACE PROJECTION ---
(function() {
    function showHoloFaceProjection() {
        const projection = document.createElement('div');
        projection.className = 'holo-projection';
        projection.style.padding = '0';
        projection.style.background = 'rgba(0,255,247,0.13)';
        projection.innerHTML = `
            <div style="position:relative; width:320px; height:320px; margin:auto;">
                <svg width="320" height="320" viewBox="0 0 320 320" style="display:block; margin:auto; filter: drop-shadow(0 0 32px #00fff7) drop-shadow(0 0 16px #ff00cc);">
                    <defs>
                        <radialGradient id="faceGlow" cx="50%" cy="50%" r="60%">
                            <stop offset="0%" stop-color="#00fff7" stop-opacity="0.8"/>
                            <stop offset="80%" stop-color="#ff00cc" stop-opacity="0.3"/>
                            <stop offset="100%" stop-color="transparent" stop-opacity="0"/>
                        </radialGradient>
                    </defs>
                    <ellipse cx="160" cy="160" rx="110" ry="130" fill="url(#faceGlow)" />
                    <ellipse cx="160" cy="160" rx="100" ry="120" fill="#111a22" opacity="0.7" />
                    <ellipse cx="120" cy="150" rx="18" ry="14" fill="#00fff7" filter="url(#glow)" />
                    <ellipse cx="200" cy="150" rx="18" ry="14" fill="#00fff7" filter="url(#glow)" />
                    <ellipse cx="120" cy="150" rx="8" ry="6" fill="#fff" opacity="0.5" />
                    <ellipse cx="200" cy="150" rx="8" ry="6" fill="#fff" opacity="0.5" />
                    <path d="M130 210 Q160 240 190 210" stroke="#00fff7" stroke-width="6" fill="none" filter="url(#glow)" />
                    <ellipse cx="160" cy="180" rx="38" ry="18" fill="#00fff7" opacity="0.08" />
                </svg>
                <div class='holo-projection-glow'></div>
            </div>
            <div style='margin-top:18px; font-size:1.2em;'>Голографический ИИ-аватар</div>
        `;
        document.body.appendChild(projection);
        setTimeout(() => projection.remove(), 4000);
    }
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.altKey && e.code === 'KeyF') {
            showHoloFaceProjection();
        }
    });
})();

// --- CHAT LOGIC FOR MODAL ---
    const chatFormModal = document.getElementById('ai-chat-form-modal');
    const chatInputModal = document.getElementById('ai-chat-input-modal');
    const chatHistoryModal = document.getElementById('ai-chat-history-modal');
    if (chatFormModal && chatInputModal && chatHistoryModal) {
      chatFormModal.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('ai-chat-form-modal submit'); // debug
        const msg = chatInputModal.value.trim();
        if (!msg) return;
        appendMessageModal('user', msg);
        chatInputModal.value = '';
        chatInputModal.disabled = true;
        fetch('/api/nvidia-chat', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
          },
          body: JSON.stringify({message: msg})
        })
        .then(r => r.json())
        .then(data => {
          if (data.answer) {
            appendMessageModal('bot', data.answer);
          } else if (data.error) {
            let errorText = 'Ошибка: ' + data.error;
            if (data.details) {
              errorText += '<br><span style="color:#ff00cc;font-size:0.95em;">' + data.details + '</span>';
            }
            appendMessageModal('bot', errorText);
          } else {
            appendMessageModal('bot', 'Нет ответа');
          }
        })
        .catch(() => {
          appendMessageModal('bot', 'Ошибка соединения с сервером');
        })
        .finally(() => {
          chatInputModal.disabled = false;
          chatInputModal.focus();
        });
      });
      function appendMessageModal(role, text) {
        const div = document.createElement('div');
        div.className = 'ai-chat-msg ' + role;
        div.innerHTML = `<span>${role === 'user' ? 'Вы' : 'Бот'}:</span> ${text}`;
        chatHistoryModal.appendChild(div);
        chatHistoryModal.scrollTop = chatHistoryModal.scrollHeight;
      }
    }
    // --- LOGOUT BUTTON IN MODAL ---
    const logoutBtnModal = document.getElementById('logout-btn-modal');
    if (logoutBtnModal) {
        logoutBtnModal.addEventListener('click', function() {
            fetch('/logout', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value || '',
                },
                credentials: 'same-origin',
            }).then(() => {
                window.location.reload();
            });
        });
    }
