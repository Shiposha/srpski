<section id="words" class="page active">
    <h2>Изучение слов</h2>
    <p>Добавляйте новые слова для изучения. Заполните поля и нажмите "Добавить слово".</p>
    
    <form class="word-form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="page" value="words">
        
        <div class="form-with-keyboard">
            <!-- Компактная клавиатура слева -->
            <div class="serbian-keyboard-compact">
                <h4>Сербские символы</h4>
                <div class="keyboard-grid-compact">
                    <button type="button" class="keyboard-key-tiny" data-latin="č" data-cyrillic="ч">č</button>
                    <button type="button" class="keyboard-key-tiny" data-latin="ć" data-cyrillic="ћ">ć</button>
                    <button type="button" class="keyboard-key-tiny" data-latin="ž" data-cyrillic="ж">ž</button>
                    <button type="button" class="keyboard-key-tiny" data-latin="š" data-cyrillic="ш">š</button>
                    <button type="button" class="keyboard-key-tiny" data-latin="đ" data-cyrillic="ђ">đ</button>
                    <button type="button" class="keyboard-key-tiny" data-latin="dž" data-cyrillic="џ">dž</button>
                    <button type="button" class="keyboard-key-tiny" data-latin="lj" data-cyrillic="љ">lj</button>
                    <button type="button" class="keyboard-key-tiny" data-latin="nj" data-cyrillic="њ">nj</button>
                    <button type="button" class="keyboard-key-tiny" data-latin="Č" data-cyrillic="Ч">Č</button>
                    <button type="button" class="keyboard-key-tiny" data-latin="Ć" data-cyrillic="Ћ">Ć</button>
                    <button type="button" class="keyboard-key-tiny" data-latin="Ž" data-cyrillic="Ж">Ž</button>
                    <button type="button" class="keyboard-key-tiny" data-latin="Š" data-cyrillic="Ш">Š</button>
                    <button type="button" class="keyboard-key-tiny" data-latin="Đ" data-cyrillic="Ђ">Đ</button>
                    <button type="button" class="keyboard-key-tiny" data-latin="Dž" data-cyrillic="Џ">Dž</button>
                    <button type="button" class="keyboard-key-tiny" data-latin="Lj" data-cyrillic="Љ">Lj</button>
                    <button type="button" class="keyboard-key-tiny" data-latin="Nj" data-cyrillic="Њ">Nj</button>
                </div>
            </div>
            
            <!-- Основные поля формы -->
            <div class="form-fields-main">
                <!-- Поля ввода слов друг под другом -->
                <div class="form-fields-stacked">
                    <div class="form-group">
                        <label for="word-latin">Сербский (латиница):</label>
                        <input type="text" id="word-latin" name="word_latin" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="word-cyrillic">Сербский (кириллица):</label>
                        <input type="text" id="word-cyrillic" name="word_cyrillic" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="word-russian">Русский перевод:</label>
                        <input type="text" id="word-russian" name="word_russian" required>
                    </div>
                </div>
                
                <!-- Кнопки под полями ввода -->
                <div class="form-buttons-row">
                    <div class="audio-upload-compact">
                        <div class="file-input-wrapper">
                            <div class="file-input-button">Выбрать аудиофайл</div>
                            <input type="file" id="word-audio-file" name="word_audio_file" accept=".mp3,audio/mpeg">
                            <span id="word-file-name" class="file-name"></span>
                        </div>
                    </div>
                    
                    <button type="button" id="translate-btn" class="translate-btn-compact" title="Автоматический перевод">
                        🌐 Переводчик
                    </button>
                </div>
                
                <button type="submit" name="add_word" class="primary-btn">Добавить слово</button>
            </div>
        </div>
    </form>
    
    <h3>Ваш словарь</h3>
    <div class="table-container">
        <table class="word-table">
            <thead>
                <tr>
                    <th>Сербский (латиница)</th>
                    <th>Сербский (кириллица)</th>
                    <th>Русский перевод</th>
                    <th>Аудио</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody id="word-list">
                <?php foreach ($words as $word): ?>
                <tr>
                    <td><?= htmlspecialchars($word['latin']) ?></td>
                    <td><?= htmlspecialchars($word['cyrillic']) ?></td>
                    <td><?= htmlspecialchars($word['russian']) ?></td>
                    <td class="audio-cell">
                        <?php if (!empty($word['audio_path'])): ?>
                            <button class="play-btn" data-audio="<?= htmlspecialchars($word['audio_path']) ?>">▶</button>
                        <?php else: ?>
                            <button class="add-audio-btn secondary-btn small-btn" 
                                    data-word-id="<?= $word['id'] ?>" 
                                    data-action="add-audio">
                                +
                            </button>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="?page=words&delete_word=<?= $word['id'] ?>" class="delete-btn" onclick="return confirm('Вы уверены, что хотите удалить это слово?')">Удалить</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Автоматическая транслитерация между латиницей и кириллицей
    const latinInput = document.getElementById('word-latin');
    const cyrillicInput = document.getElementById('word-cyrillic');
    const russianInput = document.getElementById('word-russian');
    const translateBtn = document.getElementById('translate-btn');
    
    // Виртуальная клавиатура
    const keyboardKeys = document.querySelectorAll('.keyboard-key-tiny');
    
    // Обработчики для виртуальной клавиатуры
    keyboardKeys.forEach(key => {
        key.addEventListener('click', function() {
            const latinChar = this.dataset.latin;
            const cyrillicChar = this.dataset.cyrillic;
            
            // Определяем активное поле
            const activeElement = document.activeElement;
            
            if (activeElement === latinInput) {
                insertAtCursor(latinInput, latinChar);
                // Автоматически обновляем кириллическое поле
                cyrillicInput.value = convertLatinToCyrillic(latinInput.value);
            } else if (activeElement === cyrillicInput) {
                insertAtCursor(cyrillicInput, cyrillicChar);
                // Автоматически обновляем латинское поле
                latinInput.value = convertCyrillicToLatin(cyrillicInput.value);
            } else {
                // Если ни одно поле не активно, вставляем в латинское
                insertAtCursor(latinInput, latinChar);
                cyrillicInput.value = convertLatinToCyrillic(latinInput.value);
            }
        });
    });
    
    // Функция для вставки текста в позицию курсора
    function insertAtCursor(input, text) {
        const start = input.selectionStart;
        const end = input.selectionEnd;
        
        input.value = input.value.substring(0, start) + text + input.value.substring(end);
        
        // Устанавливаем курсор после вставленного текста
        input.selectionStart = input.selectionEnd = start + text.length;
        input.focus();
    }
    
    // Функции транслитерации
    function convertLatinToCyrillic(text) {
        let result = text.replace(/Lj/g, 'Љ').replace(/lj/g, 'љ')
                         .replace(/Nj/g, 'Њ').replace(/nj/g, 'њ')
                         .replace(/Dž/g, 'Џ').replace(/dž/g, 'џ')
                         .replace(/Đ/g, 'Ђ').replace(/đ/g, 'ђ')
                         .replace(/Ć/g, 'Ћ').replace(/ć/g, 'ћ')
                         .replace(/Č/g, 'Ч').replace(/č/g, 'ч')
                         .replace(/Ž/g, 'Ж').replace(/ž/g, 'ж')
                         .replace(/Š/g, 'Ш').replace(/š/g, 'ш');
        
        const latinToCyrillicMap = {
            'a': 'а', 'b': 'б', 'v': 'в', 'g': 'г', 'd': 'д', 'e': 'е', 'z': 'з', 'i': 'и', 'j': 'ј', 
            'k': 'к', 'l': 'л', 'm': 'м', 'n': 'н', 'o': 'о', 'p': 'п', 'r': 'р', 's': 'с', 't': 'т', 
            'u': 'у', 'f': 'ф', 'h': 'х', 'c': 'ц',
            'A': 'А', 'B': 'Б', 'V': 'В', 'G': 'Г', 'D': 'Д', 'E': 'Е', 'Z': 'З', 'I': 'И', 'J': 'Ј', 
            'K': 'К', 'L': 'Л', 'M': 'М', 'N': 'Н', 'O': 'О', 'P': 'П', 'R': 'Р', 'S': 'С', 'T': 'Т', 
            'U': 'У', 'F': 'Ф', 'H': 'Х', 'C': 'Ц'
        };
        
        return result.split('').map(char => latinToCyrillicMap[char] || char).join('');
    }

    function convertCyrillicToLatin(text) {
        let result = text.replace(/Љ/g, 'Lj').replace(/љ/g, 'lj')
                         .replace(/Њ/g, 'Nj').replace(/њ/g, 'nj')
                         .replace(/Џ/g, 'Dž').replace(/џ/g, 'dž')
                         .replace(/Ђ/g, 'Đ').replace(/ђ/g, 'đ')
                         .replace(/Ћ/g, 'Ć').replace(/ћ/g, 'ć')
                         .replace(/Ч/g, 'Č').replace(/ч/g, 'č')
                         .replace(/Ж/g, 'Ž').replace(/ж/g, 'ž')
                         .replace(/Ш/g, 'Š').replace(/ш/g, 'š');
        
        const cyrillicToLatinMap = {
            'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'з': 'z', 'и': 'i', 'ј': 'j', 
            'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 
            'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c',
            'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'З': 'Z', 'И': 'I', 'Ј': 'J', 
            'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O', 'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 
            'У': 'U', 'Ф': 'F', 'Х': 'H', 'Ц': 'C'
        };
        
        return result.split('').map(char => cyrillicToLatinMap[char] || char).join('');
    }
    
    // Обработчики событий для автоматической транслитерации
    let isConverting = false;
    
    latinInput.addEventListener('input', function() {
        if (isConverting) return;
        isConverting = true;
        cyrillicInput.value = convertLatinToCyrillic(this.value);
        isConverting = false;
    });
    
    cyrillicInput.addEventListener('input', function() {
        if (isConverting) return;
        isConverting = true;
        latinInput.value = convertCyrillicToLatin(this.value);
        isConverting = false;
    });
    
    // Функция для автоматического перевода
    translateBtn.addEventListener('click', async function() {
        const serbianWord = latinInput.value.trim() || cyrillicInput.value.trim();
        const russianWord = russianInput.value.trim();
        
        // Определяем направление перевода
        let translationDirection;
        let sourceText, sourceLang, targetLang;
        
        if (serbianWord && !russianWord) {
            // Перевод с сербского на русский
            translationDirection = 'sr-ru';
            sourceText = serbianWord;
            sourceLang = 'sr';
            targetLang = 'ru';
        } else if (russianWord && !serbianWord) {
            // Перевод с русского на сербский
            translationDirection = 'ru-sr';
            sourceText = russianWord;
            sourceLang = 'ru';
            targetLang = 'sr';
        } else if (serbianWord && russianWord) {
            // Если оба поля заполнены, спрашиваем пользователя
            const userChoice = confirm('Оба поля заполнены. Хотите перевести с сербского на русский? (OK - да, Отмена - перевести с русского на сербский)');
            if (userChoice) {
                translationDirection = 'sr-ru';
                sourceText = serbianWord;
                sourceLang = 'sr';
                targetLang = 'ru';
            } else {
                translationDirection = 'ru-sr';
                sourceText = russianWord;
                sourceLang = 'ru';
                targetLang = 'sr';
            }
        } else {
            showNotification('Введите слово для перевода', 'error');
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
                    q: sourceText,
                    source: sourceLang,
                    target: targetLang,
                    format: 'text'
                })
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            
            if (data && data.translatedText) {
                if (translationDirection === 'sr-ru') {
                    // Заполняем русское поле
                    russianInput.value = data.translatedText;
                    showNotification('Перевод с сербского выполнен успешно!', 'success');
                } else {
                    // Заполняем сербские поля
                    const serbianTranslation = data.translatedText;
                    latinInput.value = serbianTranslation;
                    cyrillicInput.value = convertLatinToCyrillic(serbianTranslation);
                    showNotification('Перевод с русского выполнен успешно!', 'success');
                }
            } else {
                throw new Error('Некорректный ответ от переводчика');
            }
            
        } catch (error) {
            console.error('Translation error:', error);
            showNotification('Ошибка перевода: ' + error.message, 'error');
        } finally {
            // Восстанавливаем кнопку
            translateBtn.disabled = false;
            translateBtn.classList.remove('loading');
            translateBtn.innerHTML = '🌐 Переводчик';
        }
    });
    
    // Обработчик для выбора аудиофайла
    const audioFileInput = document.getElementById('word-audio-file');
    const fileNameSpan = document.getElementById('word-file-name');
    
    if (audioFileInput) {
        audioFileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                fileNameSpan.textContent = `Выбрано: ${fileName}`;
                fileNameSpan.style.display = 'inline-block';
            } else {
                fileNameSpan.textContent = '';
                fileNameSpan.style.display = 'none';
            }
        });
    }
    
    // Обработчик для кнопок добавления аудио к существующим словам
    document.querySelectorAll('.add-audio-btn').forEach(button => {
        button.addEventListener('click', function() {
            const wordId = this.dataset.wordId;
            const wordRow = this.closest('tr');
            const latinText = wordRow.querySelector('td:first-child').textContent.trim();
            
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = '.mp3,audio/mpeg';
            fileInput.style.display = 'none';
            
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    const file = this.files[0];
                    
                    // Показываем индикатор загрузки
                    const originalButton = button;
                    originalButton.disabled = true;
                    originalButton.textContent = '...';
                    
                    // Создаем FormData для отправки файла
                    const formData = new FormData();
                    formData.append('audio_file', file);
                    formData.append('word_id', wordId);
                    
                    // Отправляем запрос на сервер
                    fetch('/handlers/add-word-audio-handler.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Обновляем интерфейс
                            const audioCell = originalButton.closest('.audio-cell');
                            audioCell.innerHTML = `<button class="play-btn" data-audio="${data.audio_path}">▶</button>`;
                            
                            // Инициализируем новую кнопку воспроизведения
                            const newPlayBtn = audioCell.querySelector('.play-btn');
                            if (newPlayBtn) {
                                newPlayBtn.addEventListener('click', function() {
                                    const audioPath = this.dataset.audio;
                                    if (typeof playAudio === 'function') {
                                        playAudio(audioPath, this);
                                    } else {
                                        const audio = new Audio(audioPath);
                                        audio.play().catch(error => {
                                            console.error('Error playing audio:', error);
                                            showNotification('Ошибка воспроизведения аудио', 'error');
                                        });
                                    }
                                });
                            }
                            
                            // Показываем уведомление
                            showNotification('Аудиофайл успешно добавлен к слову "' + latinText + '"', 'success');
                        } else {
                            throw new Error(data.error || 'Неизвестная ошибка сервера');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Ошибка при добавлении аудиофайла: ' + error.message, 'error');
                        
                        // Восстанавливаем кнопку
                        originalButton.disabled = false;
                        originalButton.textContent = '+';
                    });
                }
            });
            
            document.body.appendChild(fileInput);
            fileInput.click();
            document.body.removeChild(fileInput);
        });
    });
    
    // Функция для показа уведомлений
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            z-index: 10000;
            max-width: 400px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            animation: slideIn 0.3s ease-out;
        `;
        
        if (type === 'success') {
            notification.style.backgroundColor = '#28a745';
        } else if (type === 'error') {
            notification.style.backgroundColor = '#dc3545';
        } else {
            notification.style.backgroundColor = '#17a2b8';
        }
        
        notification.textContent = message;
        document.body.appendChild(notification);
        
        // Автоматически удаляем уведомление через 5 секунд
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-in';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 5000);
    }

    // CSS анимации для уведомлений
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        .loading-spinner {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
});
</script>