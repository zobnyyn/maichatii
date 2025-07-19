// JS для страницы чата с ИИ

document.addEventListener('DOMContentLoaded', function() {
    const chatHistory = document.getElementById('ai-chat-history');
    const chatForm = document.getElementById('ai-chat-form-main');
    const chatInput = document.getElementById('ai-chat-input');
    const debugToggle = document.getElementById('debug-toggle');
    const debugPanel = document.getElementById('debug-panel');
    const debugContent = document.getElementById('debug-content');
    const historyToggle = document.getElementById('history-toggle');
    const historyModal = document.getElementById('history-modal');
    const historyClose = document.getElementById('history-close');
    const registerToggle = document.getElementById('register-toggle');
    const registerModal = document.getElementById('register-modal');
    const registerClose = document.getElementById('register-close');
    const loginToggle = document.getElementById('login-toggle');
    const loginModal = document.getElementById('login-modal');
    const loginClose = document.getElementById('login-close');
    let debugMode = false;
    debugToggle?.addEventListener('click', function() {
        debugMode = !debugMode;
        debugPanel.style.display = debugMode ? 'block' : 'none';
    });
    historyToggle?.addEventListener('click', function() {
        historyModal.style.display = 'flex';
        const historyList = document.getElementById('history-list');
        if (historyList) {
            setTimeout(() => {
                historyList.scrollTop = historyList.scrollHeight;
            }, 100);
        }
    });
    historyClose?.addEventListener('click', function() {
        historyModal.style.display = 'none';
    });
    registerToggle?.addEventListener('click', function() {
        registerModal.style.display = 'flex';
    });
    registerClose?.addEventListener('click', function() {
        registerModal.style.display = 'none';
    });
    loginToggle?.addEventListener('click', function() {
        loginModal.style.display = 'flex';
    });
    loginClose?.addEventListener('click', function() {
        loginModal.style.display = 'none';
    });
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && historyModal.style.display === 'flex') {
            historyModal.style.display = 'none';
        }
        if (e.key === 'Escape' && registerModal.style.display === 'flex') {
            registerModal.style.display = 'none';
        }
        if (e.key === 'Escape' && loginModal.style.display === 'flex') {
            loginModal.style.display = 'none';
        }
    });
    function appendMessage(role, text) {
        const div = document.createElement('div');
        div.className = 'chat-msg ' + role;
        if (role === 'bot') {
            div.innerHTML = `<img src='/images/avatar.jpg' class='chat-avatar' alt='Аватарка бота'> <span class='chat-text'>${text}</span>`;
        } else {
            div.innerHTML = `<span class='chat-text'>${text}</span>`;
        }
        chatHistory.appendChild(div);
        chatHistory.scrollTop = chatHistory.scrollHeight;
    }
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content || '';
    }
    if (chatForm) {
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const msg = chatInput.value.trim();
            if (!msg) return;
            appendMessage('user', msg);
            chatInput.value = '';
            chatInput.disabled = true;
            fetch('/api/nvidia-chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                },
                body: JSON.stringify({message: msg})
            })
            .then(async r => {
                let status = r.status;
                let json = await r.json();
                if (debugMode) {
                    debugContent.textContent = JSON.stringify({status, ...json}, null, 2);
                }
                return json;
            })
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
            .catch((err) => {
                let errorMsg = 'Ошибка соединения с сервером';
                if (err && err.message) {
                    errorMsg += `<br><span style=\"color:#ff00cc;font-size:0.95em;\">${err.message}</span>`;
                }
                if (debugMode) {
                    debugContent.textContent = 'Fetch error: ' + (err && err.message ? err.message : String(err));
                }
                appendMessage('bot', errorMsg);
            })
            .finally(() => {
                chatInput.disabled = false;
                chatInput.focus();
            });
        });
    }
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            loginForm.querySelectorAll('.login-error-msg').forEach(el => el.remove());
            const formData = new FormData(loginForm);
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
                credentials: 'same-origin',
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
    if (chatHistory) {
        const scrollToBottom = () => {
            chatHistory.scrollTop = chatHistory.scrollHeight;
        };
        window.addEventListener('load', scrollToBottom);
        const observer = new MutationObserver(() => {
            setTimeout(scrollToBottom, 50);
        });
        observer.observe(chatHistory, { childList: true, subtree: true });
    }
});
