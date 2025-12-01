<?php
require_once 'config/config.php';
require_once 'config/functions.php';
require_once 'includes/morphology.php'; // Подключаем морфологию

// Обработка формы добавления слова
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_word'])) {
    $baseWord = trim($_POST['base_word']);
    $gender = $_POST['gender'];
    $russianTranslation = trim($_POST['russian_translation']);
    
    // Получаем отредактированные падежи из формы
    $editedCases = [];
    foreach ($_POST['cases'] as $caseName => $forms) {
        $editedCases[$caseName] = [
            trim($forms['latin']),
            trim($forms['cyrillic'])
        ];
    }
    
    // Сохраняем в базу
    saveEditedCases($pdo, $baseWord, $gender, $russianTranslation, $editedCases);
    
    echo '<div class="success-message">Слово "'.$baseWord.'" успешно добавлено со всеми падежами!</div>';
}

// Функция сохранения отредактированных падежей
function saveEditedCases($pdo, $baseWord, $gender, $russianTranslation, $cases) {
    $case_names_cyrillic = [
        'nominativ' => 'Именительный',
        'genitiv' => 'Родительный',
        'dativ' => 'Дательный',
        'akuzativ' => 'Винительный',
        'vokativ' => 'Звательный',
        'instrumental' => 'Творительный',
        'lokativ' => 'Предложный'  
    ];
    
    foreach ($cases as $caseName => $forms) {
        $stmt = $pdo->prepare("
            INSERT IGNORE INTO word_cases 
            (base_word, word_latin, word_cyrillic, case_name, case_name_cyrillic, gender, russian_translation)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $baseWord,
            $forms[0],
            $forms[1],
            $caseName,
            $case_names_cyrillic[$caseName],
            $gender,
            $russianTranslation
        ]);
    }
}
?>

<div class="admin-container">
    <h2>Добавить новое слово с автоматической генерацией падежей</h2>
    
    <form method="POST" class="admin-form" id="word-form">
        <div class="form-group">
            <label for="base_word">Базовое слово (именительный падеж):</label>
            <input type="text" id="base_word" name="base_word" required placeholder="student, knjiga, mesto">
        </div>
        
        <div class="form-group">
            <label for="gender">Род слова:</label>
            <select id="gender" name="gender" required>
                <option value="m">Мужской (m)</option>
                <option value="f">Женский (f)</option>
                <option value="n">Средний (n)</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="russian_translation">Русский перевод:</label>
            <div class="translate-container">
                <input type="text" id="russian_translation" name="russian_translation" required placeholder="студент, книга, место">
                <button type="button" id="translate-btn" class="translate-btn" title="Автоматический перевод через LibreTranslate">
                    🌐 Переводчик
                </button>
            </div>
            <small class="form-hint">Нажмите кнопку для автоматического перевода</small>
        </div>
        
        <div class="form-group preview-section">
            <label>Предпросмотр и редактирование падежей:</label>
            <div id="cases-preview" class="cases-preview">
                <p class="preview-hint">Введите базовое слово для предпросмотра падежей</p>
            </div>
        </div>
        
        <!-- Блок проверки на Definify -->
        <div class="form-group preview-section">
            <label>Проверка падежей на Definify:</label>
            <div id="definify-check" class="definify-check">
                <div class="definify-controls">
                    <input type="text" id="definify-word" placeholder="Слово для проверки" class="definify-input">
                    <button type="button" id="check-definify-btn" class="secondary-btn">🔍 Проверить на Definify</button>
                </div>
                <div id="definify-results" class="definify-results" style="display: none;">
                    <h4>Результаты проверки:</h4>
                    <div id="definify-content"></div>
                </div>
            </div>
        </div>
        
        <button type="submit" name="add_word" class="primary-btn">Добавить слово со всеми падежами</button>
    </form>
</div>

<script>
// Предпросмотр падежей при изменении данных
document.addEventListener('DOMContentLoaded', function() {
    const baseWordInput = document.getElementById('base_word');
    const genderSelect = document.getElementById('gender');
    const previewDiv = document.getElementById('cases-preview');
    const translateBtn = document.getElementById('translate-btn');
    const russianInput = document.getElementById('russian_translation');
    const definifyWordInput = document.getElementById('definify-word');
    const checkDefinifyBtn = document.getElementById('check-definify-btn');
    const definifyResults = document.getElementById('definify-results');
    const definifyContent = document.getElementById('definify-content');
    const wordForm = document.getElementById('word-form');
    
    function updatePreview() {
        const baseWord = baseWordInput.value.trim().toLowerCase();
        const gender = genderSelect.value;
        
        if (!baseWord) {
            previewDiv.innerHTML = '<p class="preview-hint">Введите базовое слово для предпросмотра падежей</p>';
            return;
        }
        
        // Отправляем AJAX запрос для генерации падежей
        fetch('api/generate-cases-preview.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({word: baseWord, gender: gender})
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                previewDiv.innerHTML = generateEditablePreviewHTML(data.cases);
                // Автоматически заполняем поле для Definify
                definifyWordInput.value = baseWord;
            } else {
                previewDiv.innerHTML = `<p class="error-message">${data.error || 'Неизвестная ошибка'}</p>`;
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            previewDiv.innerHTML = '<p class="error-message">Ошибка при генерации предпросмотра. Проверьте консоль для подробностей.</p>';
        });
    }
    
    baseWordInput.addEventListener('input', updatePreview);
    genderSelect.addEventListener('change', updatePreview);
    
    // Функция для автоматического перевода через LibreTranslate
    translateBtn.addEventListener('click', async function() {
        const baseWord = baseWordInput.value.trim();
        
        if (!baseWord) {
            alert('Введите сербское слово для перевода');
            return;
        }
        
        // Показываем индикатор загрузки
        translateBtn.disabled = true;
        translateBtn.classList.add('loading');
        translateBtn.innerHTML = '<span class="loading-spinner"></span> Перевод...';
        
        try {
            const response = await fetch('https://translate.svhip.com/translate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    q: baseWord,
                    source: 'sr',
                    target: 'ru',
                    format: 'text'
                })
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            
            if (data && data.translatedText) {
                russianInput.value = data.translatedText;
                translateBtn.innerHTML = '✅ Переведено!';
                
                // Через 2 секунды возвращаем обычный вид кнопки
                setTimeout(() => {
                    translateBtn.innerHTML = '🌐 Переводчик';
                    translateBtn.classList.remove('loading');
                    translateBtn.disabled = false;
                }, 2000);
            } else {
                throw new Error('Некорректный ответ от переводчика');
            }
            
        } catch (error) {
            console.error('Translation error:', error);
            translateBtn.innerHTML = '❌ Ошибка';
            translateBtn.classList.remove('loading');
            
            // Через 2 секунды возвращаем обычный вид кнопки
            setTimeout(() => {
                translateBtn.innerHTML = '🌐 Переводчик';
                translateBtn.disabled = false;
            }, 2000);
            
            // Более информативное сообщение об ошибке
            if (error.message.includes('Failed to fetch') || error.message.includes('ERR_CONNECTION_REFUSED')) {
                alert('Не удалось подключиться к серверу перевода. Проверьте:\n1. Запущен ли LibreTranslate в Docker\n2. Доступен ли https://translate.svhip.com\n3. Настройки сети и портов');
            } else {
                alert('Ошибка перевода: ' + error.message);
            }
        }
    });
    
    // Функция для проверки слова на Definify
    checkDefinifyBtn.addEventListener('click', async function() {
        const word = definifyWordInput.value.trim();
        
        if (!word) {
            alert('Введите слово для проверки на Definify');
            return;
        }
        
        // Показываем индикатор загрузки
        checkDefinifyBtn.disabled = true;
        checkDefinifyBtn.innerHTML = '<span class="loading-spinner"></span> Проверка...';
        
        try {
            // Создаем iframe для загрузки Definify
            definifyContent.innerHTML = `
                <div class="definify-loading">
                    <p>Загрузка страницы definify.com...</p>
                    <iframe 
                        src="https://definify.com/word/${encodeURIComponent(word)}" 
                        style="width: 100%; height: 500px; border: 1px solid #ddd; border-radius: 4px;"
                        onload="document.getElementById('check-definify-btn').innerHTML = '🔍 Проверить на Definify'; document.getElementById('check-definify-btn').disabled = false;"
                    ></iframe>
                    <div class="definify-links">
                        <a href="https://definify.com/word/${encodeURIComponent(word)}" target="_blank" class="secondary-btn">📖 Открыть в новой вкладке</a>
                        <button type="button" class="secondary-btn" onclick="copyDefinifyLink()">📋 Скопировать ссылку</button>
                    </div>
                </div>
            `;
            
            definifyResults.style.display = 'block';
            
        } catch (error) {
            console.error('Definify error:', error);
            definifyContent.innerHTML = `
                <div class="error-message">
                    <p>Ошибка при загрузке Definify:</p>
                    <p>${error.message}</p>
                    <p>Попробуйте открыть ссылку вручную:</p>
                    <a href="https://definify.com/word/${encodeURIComponent(word)}" target="_blank" class="primary-btn">Открыть definify.com</a>
                </div>
            `;
            definifyResults.style.display = 'block';
            checkDefinifyBtn.innerHTML = '🔍 Проверить на Definify';
            checkDefinifyBtn.disabled = false;
        }
    });
    
    // Функция для копирования ссылки на Definify
    window.copyDefinifyLink = function() {
        const word = definifyWordInput.value.trim();
        const url = `https://definify.com/word/${encodeURIComponent(word)}`;
        
        navigator.clipboard.writeText(url).then(() => {
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '✅ Скопировано!';
            setTimeout(() => {
                btn.innerHTML = originalText;
            }, 2000);
        }).catch(err => {
            console.error('Ошибка копирования: ', err);
            alert('Не удалось скопировать ссылку');
        });
    };
    
    // Автозаполнение поля проверки при вводе основного слова
    baseWordInput.addEventListener('input', function() {
        definifyWordInput.value = baseWordInput.value;
    });
    
    // Изначальный предпросмотр
    updatePreview();
});

function generateEditablePreviewHTML(cases) {
    let html = `
        <table class="preview-table editable-cases-table">
            <thead>
                <tr>
                    <th>Падеж</th>
                    <th>Латиница</th>
                    <th>Кириллица</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    // Правильный порядок падежей: звательный после винительного
    const caseOrder = [
        'nominativ',
        'genitiv', 
        'dativ',
        'akuzativ',
        'vokativ', 
        'instrumental',
        'lokativ'
    ];
    
    const caseNames = {
        'nominativ': 'Именительный',
        'genitiv': 'Родительный', 
        'dativ': 'Дательный',
        'akuzativ': 'Винительный',
        'vokativ': 'Звательный',
        'instrumental': 'Творительный',
        'lokativ': 'Предложный'
    };
    
    // Используем правильный порядок вместо Object.entries(cases)
    caseOrder.forEach(caseName => {
        if (cases[caseName]) {
            const forms = cases[caseName];
            html += `
            <tr>
                <td><strong>${caseNames[caseName]}</strong></td>
                <td>
                    <input type="text" 
                           name="cases[${caseName}][latin]" 
                           value="${forms[0]}" 
                           class="case-input"
                           placeholder="Латиница">
                </td>
                <td>
                    <input type="text" 
                           name="cases[${caseName}][cyrillic]" 
                           value="${forms[1]}" 
                           class="case-input"
                           placeholder="Кириллица">
                </td>
            </tr>
            `;
        }
    });
    
    html += `
            </tbody>
        </table>
        <small class="form-hint">Вы можете отредактировать любое слово перед добавлением в базу данных</small>
    `;
    return html;
}
</script>