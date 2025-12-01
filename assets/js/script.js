// Навигация между страницами
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function(e) {
        // Убираем активный класс у всех ссылок
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        
        // Добавляем активный класс к текущей ссылке
        this.classList.add('active');
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Для формы слов
    const wordFileInput = document.getElementById('word-audio-file');
    
    if (wordFileInput) {
        // Создаем span для отображения имени файла, если его еще нет
        let wordFileName = document.getElementById('word-file-name');
        if (!wordFileName) {
            wordFileName = document.createElement('span');
            wordFileName.className = 'file-name';
            wordFileName.id = 'word-file-name';
            wordFileInput.parentNode.appendChild(wordFileName);
        }
        
        wordFileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                wordFileName.textContent = 'Выбран файл: ' + this.files[0].name;
            } else {
                wordFileName.textContent = '';
            }
        });
    }

    // Для формы предложений
    const sentenceFileInput = document.getElementById('sentence-audio-file');
    
    if (sentenceFileInput) {
        // Создаем span для отображения имени файла, если его еще нет
        let sentenceFileName = document.getElementById('sentence-file-name');
        if (!sentenceFileName) {
            sentenceFileName = document.createElement('span');
            sentenceFileName.className = 'file-name';
            sentenceFileName.id = 'sentence-file-name';
            sentenceFileInput.parentNode.appendChild(sentenceFileName);
        }
        
        sentenceFileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                sentenceFileName.textContent = 'Выбран файл: ' + this.files[0].name;
            } else {
                sentenceFileName.textContent = '';
            }
        });
    }

    // КОД ДЛЯ СТРАНИЦЫ ПАДЕЖЕЙ - выполняется только если элементы существуют
    const wordSelect = document.getElementById('word-select');
    const caseResults = document.getElementById('case-results');
    const caseTableBody = document.getElementById('case-table-body');
    const wordTitle = document.getElementById('word-title');
    const wordInfo = document.getElementById('word-info');
    const caseError = document.getElementById('case-error');
    const wordCount = document.getElementById('word-count');
    const showAllWordsBtn = document.getElementById('show-all-words');
    const allWordsSection = document.getElementById('all-words-section');
    const allWordsList = document.getElementById('all-words-list');

    // Динамическая ссылка на Definify для текущего слова
    const wordDefinifyLink = document.getElementById('word-definify-link');
    const currentWordSpan = document.getElementById('current-word');

    if (wordSelect && wordDefinifyLink && currentWordSpan) {
        wordSelect.addEventListener('change', function() {
            const selectedWord = this.value;
            if (selectedWord) {
                currentWordSpan.textContent = selectedWord;
                wordDefinifyLink.href = `https://definify.com/search?lang=sr&q=${encodeURIComponent(selectedWord)}`;
                wordDefinifyLink.style.display = 'inline-block';
            } else {
                wordDefinifyLink.style.display = 'none';
            }
        });
    }

    // Если мы на странице падежей, загружаем список слов
    if (wordSelect && caseResults) {
        // === ВСЕ ФУНКЦИИ ОБЪЯВЛЯЮТСЯ ДО ИХ ВЫЗОВА ===
        
        // Функция для получения названия рода
        function getGenderName(gender) {
            const genders = {
                'm': 'мужской род',
                'f': 'женский род',
                'n': 'средний род'
            };
            return genders[gender] || 'не указан';
        }
        
        // Функция для показа ошибок
        function showCaseError(message) {
            if (!caseError) return;
            caseError.textContent = message;
            caseError.style.display = 'block';
            if (caseResults) caseResults.style.display = 'none';
        }
        
        // Функция для отображения результатов
        function displayCaseResults(data) {
            if (!wordSelect || !wordTitle || !wordInfo || !caseResults || !caseTableBody) return;
            
            const selectedOption = wordSelect.options[wordSelect.selectedIndex];
            const translation = selectedOption ? selectedOption.getAttribute('data-translation') : '';
            
            wordTitle.textContent = data.original_word;
            
            // Отображаем информацию о слове
            const genderNames = {
                'm': 'мужской род',
                'f': 'женский род', 
                'n': 'средний род'
            };
            
            wordInfo.innerHTML = `
                <div style="background: #e8f4fd; padding: 10px; border-radius: 4px;">
                    <strong>Базовая форма:</strong> ${data.base_word} | 
                    <strong>Род:</strong> ${genderNames[data.gender]} |
                    <strong>Перевод:</strong> ${translation || 'не указан'}
                </div>
            `;
            
            caseResults.style.display = 'block';

            // Очищаем таблицу
            caseTableBody.innerHTML = '';

            // Заполняем таблицу падежами
            const casesWithQuestions = [
                { name: 'Именительный', key: 'nominativ', question: 'ко? шта?' },
                { name: 'Родительный', key: 'genitiv', question: 'од кога? од чега?' },
                { name: 'Дательный', key: 'dativ', question: 'коме? чему?' },
                { name: 'Винительный', key: 'akuzativ', question: 'кога? шта?' },
                { name: 'Звательный', key: 'vokativ', question: 'обращение' },
                { name: 'Творительный', key: 'instrumental', question: 'с ким? чиме?' },
                { name: 'Предложный', key: 'lokativ', question: 'о коме? о чему?' }
            ];

            casesWithQuestions.forEach(caseItem => {
                const caseData = data.cases.find(c => c.case_name === caseItem.key);
                if (caseData) {
                    const row = document.createElement('tr');
                    
                    row.innerHTML = `
                        <td>
                            <strong>${caseData.case_name_cyrillic}</strong><br>
                            <small>(${caseItem.key})</small>
                        </td>
                        <td>${caseItem.question}</td>
                        <td>${caseData.word_latin}</td>
                        <td>${caseData.word_cyrillic}</td>
                    `;
                    
                    caseTableBody.appendChild(row);
                }
            });

            // Прокручиваем к результатам
            caseResults.scrollIntoView({ behavior: 'smooth' });
        }
        
        // Функция для получения падежных форм
        async function fetchSerbianCases(word) {
            if (caseError) caseError.style.display = 'none';
            if (caseResults) caseResults.style.display = 'none';

            try {
                const response = await fetch('./api/serbian_cases.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ word: word })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    displayCaseResults(data);
                } else {
                    showCaseError(data.error || 'Произошла ошибка при получении данных');
                }
            } catch (error) {
                console.error('Error:', error);
                showCaseError('Ошибка соединения с сервером: ' + error.message);
            }
        }
        
        // Функция для показа/скрытия списка всех слов
        function toggleAllWordsList() {
            if (!allWordsSection || !showAllWordsBtn) return;
            
            if (allWordsSection.style.display === 'none') {
                allWordsSection.style.display = 'block';
                showAllWordsBtn.textContent = 'Скрыть все слова';
            } else {
                allWordsSection.style.display = 'none';
                showAllWordsBtn.textContent = 'Показать все слова';
            }
        }
        
        // Функция для заполнения списка всех слов
        function populateAllWordsList(words) {
            if (!allWordsList) return;
            
            allWordsList.innerHTML = '';
            
            const wordsGrid = document.createElement('div');
            wordsGrid.className = 'words-grid';
            
            words.forEach(word => {
                const wordCard = document.createElement('div');
                wordCard.className = 'word-card';
                wordCard.innerHTML = `
                    <div class="word-latin">${word.word_latin}</div>
                    <div class="word-cyrillic">${word.word_cyrillic}</div>
                    <div class="word-translation">${word.russian_translation || 'нет перевода'}</div>
                    <div class="word-gender">${getGenderName(word.gender)}</div>
                `;
                
                // При клике на карточку выбираем это слово
                wordCard.addEventListener('click', function() {
                    wordSelect.value = word.base_word;
                    fetchSerbianCases(word.base_word);
                    // Прокручиваем к результатам
                    caseResults.scrollIntoView({ behavior: 'smooth' });
                });
                
                wordsGrid.appendChild(wordCard);
            });
            
            allWordsList.appendChild(wordsGrid);
        }
        
        // Функция для обновления счетчика слов
        function updateWordCount(count) {
            if (!wordCount) return;
            wordCount.textContent = `В базе данных: ${count} слов`;
        }
        
        // Функция для заполнения выпадающего списка
        function populateWordSelect(words) {
            if (!wordSelect) return;
            
            wordSelect.innerHTML = '<option value="">-- Выберите слово --</option>';
            
            words.forEach(word => {
                const option = document.createElement('option');
                option.value = word.base_word;
                // Показываем слово в кириллице, а если его нет, то в латинице
                const displayText = word.word_cyrillic || word.word_latin;
                option.textContent = displayText;
                option.setAttribute('data-translation', word.russian_translation || '');
                option.setAttribute('data-gender', word.gender || '');
                wordSelect.appendChild(option);
            });
        }
        
        // Функция для показа тестовых данных
        function showTestData() {
            const testWords = [
                { base_word: 'student', word_latin: 'student', word_cyrillic: 'студент', russian_translation: 'студент', gender: 'm' },
                { base_word: 'knjiga', word_latin: 'knjiga', word_cyrillic: 'књига', russian_translation: 'книга', gender: 'f' },
                { base_word: 'mesto', word_latin: 'mesto', word_cyrillic: 'место', russian_translation: 'место', gender: 'n' }
            ];
            
            populateWordSelect(testWords);
            if (wordCount) wordCount.textContent = 'Тестовые данные (3 слова)';
            if (allWordsList) populateAllWordsList(testWords);
            
            showCaseError('Используются тестовые данные. Проверьте настройки базы данных.');
        }
        
        // Функция для загрузки списка слов
        async function loadWordsList() {
            try {
                const response = await fetch('./api/words_list.php');                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();

                if (data.success) {
                    populateWordSelect(data.words);
                    if (wordCount) updateWordCount(data.count);
                    if (allWordsList) populateAllWordsList(data.words);
                } else {
                    showCaseError('Ошибка при загрузке списка слов: ' + (data.error || 'Неизвестная ошибка'));
                    if (wordCount) wordCount.textContent = 'Ошибка загрузки';
                }
            } catch (error) {
                console.error('Error loading words:', error);
                showCaseError('Ошибка соединения с сервером: ' + error.message);
                if (wordCount) wordCount.textContent = 'Ошибка загрузки';
                
                // Покажем тестовые данные для отладки
                showTestData();
            }
        }
        
        // === ТОЛЬКО ПОСЛЕ ОБЪЯВЛЕНИЯ ВСЕХ ФУНКЦИЙ ВЫЗЫВАЕМ ЗАГРУЗКУ ===
        loadWordsList();

        // Обработчик выбора слова
        wordSelect.addEventListener('change', function() {
            const selectedWord = this.value;
            if (selectedWord) {
                fetchSerbianCases(selectedWord);
            } else {
                caseResults.style.display = 'none';
                if (caseError) caseError.style.display = 'none';
            }
        });

        // Обработчик кнопки "Показать все слова"
        if (showAllWordsBtn) {
            showAllWordsBtn.addEventListener('click', function() {
                toggleAllWordsList();
            });
        }
    }

    // Инициализация кнопок воспроизведения аудио
    initializeAudioPlayers();

    // Аудиоплеер для уроков "Учим Сербский 1"
    const lessonSelect = document.getElementById('lesson-select');
    const playPauseLessonBtn = document.getElementById('play-pause-lesson');
    const stopLessonBtn = document.getElementById('stop-lesson');
    const audioProgress = document.getElementById('audio-progress');
    const currentTimeEl = document.getElementById('current-time');
    const durationEl = document.getElementById('duration');

    let lessonAudioPlayer = null;
    let isPlaying = false;
    let currentAudioFile = '';

    if (lessonSelect && playPauseLessonBtn) {
        // Создаем отдельный аудиоплеер для уроков
        lessonAudioPlayer = new Audio();
        
        // Обработчик выбора урока
        lessonSelect.addEventListener('change', function() {
            if (this.value) {
                playPauseLessonBtn.disabled = false;
                if (stopLessonBtn) stopLessonBtn.disabled = false;
                
                // Если выбран новый файл, сбрасываем состояние
                if (this.value !== currentAudioFile) {
                    currentAudioFile = this.value;
                    resetAudioState();
                    lessonAudioPlayer.src = currentAudioFile;
                }
            } else {
                playPauseLessonBtn.disabled = true;
                if (stopLessonBtn) stopLessonBtn.disabled = true;
            }
        });
        
        // Кнопка воспроизведения/паузы
        playPauseLessonBtn.addEventListener('click', function() {
            if (!currentAudioFile) return;
            
            if (isPlaying) {
                // Пауза - просто останавливаем воспроизведение
                lessonAudioPlayer.pause();
                isPlaying = false;
                playPauseLessonBtn.textContent = '▶';
                playPauseLessonBtn.classList.remove('playing');
            } else {
                // Воспроизведение - продолжаем с текущей позиции
                lessonAudioPlayer.play().then(() => {
                    isPlaying = true;
                    playPauseLessonBtn.textContent = '⏸';
                    playPauseLessonBtn.classList.add('playing');
                }).catch(error => {
                    console.error('Ошибка воспроизведения:', error);
                    alert('Ошибка воспроизведения аудиофайла.');
                });
            }
        });
        
        // Кнопка остановки
        if (stopLessonBtn) {
            stopLessonBtn.addEventListener('click', function() {
                lessonAudioPlayer.pause();
                lessonAudioPlayer.currentTime = 0;
                isPlaying = false;
                playPauseLessonBtn.textContent = '▶';
                playPauseLessonBtn.classList.remove('playing');
                updateProgress(0, lessonAudioPlayer.duration || 0);
            });
        }
        
        // Обработчик клика на progress bar для перемотки
        if (audioProgress) {
            audioProgress.addEventListener('click', function(e) {
                if (!lessonAudioPlayer.duration) return;
                
                // Получаем позицию клика относительно progress bar
                const rect = this.getBoundingClientRect();
                const clickX = e.clientX - rect.left;
                const width = rect.width;
                const percent = clickX / width;
                
                // Устанавливаем новое время воспроизведения
                const newTime = percent * lessonAudioPlayer.duration;
                lessonAudioPlayer.currentTime = newTime;
                
                // Обновляем прогресс
                updateProgress(newTime, lessonAudioPlayer.duration);
                audioProgress.value = percent * 100;
            });
        }
        
        // Обновление прогресса воспроизведения
        lessonAudioPlayer.addEventListener('timeupdate', function() {
            if (lessonAudioPlayer.duration) {
                const progress = (lessonAudioPlayer.currentTime / lessonAudioPlayer.duration) * 100;
                updateProgress(lessonAudioPlayer.currentTime, lessonAudioPlayer.duration);
                if (audioProgress) audioProgress.value = progress;
            }
        });
        
        // Когда аудио загружено
        lessonAudioPlayer.addEventListener('loadedmetadata', function() {
            updateProgress(0, lessonAudioPlayer.duration);
        });
        
        // Когда воспроизведение закончено
        lessonAudioPlayer.addEventListener('ended', function() {
            isPlaying = false;
            playPauseLessonBtn.textContent = '▶';
            playPauseLessonBtn.classList.remove('playing');
            if (audioProgress) audioProgress.value = 100;
            updateProgress(lessonAudioPlayer.duration, lessonAudioPlayer.duration);
        });
        
        // Обработчик ошибок загрузки
        lessonAudioPlayer.addEventListener('error', function() {
            console.error('Ошибка загрузки аудиофайла:', currentAudioFile);
            isPlaying = false;
            playPauseLessonBtn.textContent = '▶';
            playPauseLessonBtn.classList.remove('playing');
            playPauseLessonBtn.disabled = true;
            alert('Ошибка загрузки аудиофайла. Проверьте путь к файлу.');
        });
        
        // Функция сброса состояния аудио
        function resetAudioState() {
            isPlaying = false;
            playPauseLessonBtn.textContent = '▶';
            playPauseLessonBtn.classList.remove('playing');
            if (lessonAudioPlayer) {
                lessonAudioPlayer.pause();
                lessonAudioPlayer.currentTime = 0;
            }
            if (audioProgress) audioProgress.value = 0;
            updateProgress(0, 0);
        }
        
        // Функция обновления времени
        function updateProgress(current, duration) {
            if (currentTimeEl && durationEl) {
                currentTimeEl.textContent = formatTime(current);
                durationEl.textContent = formatTime(duration);
            }
        }
        
        // Функция форматирования времени
        function formatTime(seconds) {
            if (isNaN(seconds) || seconds === Infinity) return '0:00';
            
            const minutes = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
        }
    }
});

// Глобальная переменная для отслеживания текущего воспроизведения
let currentAudioButton = null;

// Инициализация аудиоплееров
function initializeAudioPlayers() {
    // Добавляем обработчики для всех кнопок воспроизведения
    document.querySelectorAll('.play-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const audioFile = this.getAttribute('data-audio');
            playAudio(audioFile, this);
        });
    });

    // Останавливаем воспроизведение при переходе на другую страницу
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            const audioPlayer = document.getElementById('audio-player');
            if (audioPlayer && !audioPlayer.paused) {
                audioPlayer.pause();
                audioPlayer.currentTime = 0;
                if (currentAudioButton) {
                    currentAudioButton.classList.remove('playing');
                    currentAudioButton.innerHTML = '▶';
                    currentAudioButton = null;
                }
            }
        });
    });
}

// Воспроизведение аудио с исправлением для Firefox
function playAudio(audioFile, button) {
    console.log("Attempting to play audio:", audioFile);
    
    if (!audioFile) {
        console.error("No audio file specified");
        return;
    }
    
    const audioPlayer = document.getElementById('audio-player');
    if (!audioPlayer) {
        console.error("Audio player element not found");
        return;
    }
    
    // Проверяем, является ли путь абсолютным URL
    if (!audioFile.startsWith('http') && !audioFile.startsWith('/') && !audioFile.startsWith('./')) {
        console.warn("Audio path might be relative, adding base path:", audioFile);
        // Добавляем базовый путь если нужно
        audioFile = './' + audioFile;
    }
    
    // Если уже воспроизводится другой файл, останавливаем его
    if (currentAudioButton && currentAudioButton !== button) {
        audioPlayer.pause();
        audioPlayer.currentTime = 0;
        currentAudioButton.classList.remove('playing');
        currentAudioButton.innerHTML = '▶';
    }
    
    // Если нажата та же кнопка, что и сейчас воспроизводится
    if (currentAudioButton === button && !audioPlayer.paused) {
        audioPlayer.pause();
        button.classList.remove('playing');
        button.innerHTML = '▶';
        currentAudioButton = null;
        return;
    }
    
    // Устанавливаем новый источник
    audioPlayer.src = audioFile;
    
    // Сбрасываем время воспроизведения
    audioPlayer.currentTime = 0;
    
    // Обновляем UI
    if (currentAudioButton) {
        currentAudioButton.classList.remove('playing');
        currentAudioButton.innerHTML = '▶';
    }
    button.classList.add('playing');
    button.innerHTML = '⏸';
    currentAudioButton = button;
    
    console.log("Audio source set to:", audioPlayer.src);
    
    // Воспроизводим
    const playPromise = audioPlayer.play();
    
    if (playPromise !== undefined) {
        playPromise.then(() => {
            console.log("Audio playback started successfully");
        }).catch(error => {
            console.error('Ошибка воспроизведения:', error);
            button.classList.remove('playing');
            button.innerHTML = '▶';
            currentAudioButton = null;
            
            // Более информативное сообщение об ошибке
            let errorMessage = 'Ошибка воспроизведения аудиофайла. ';
            if (error.name === 'NotSupportedError') {
                errorMessage += 'Формат файла не поддерживается или файл поврежден.';
            } else if (error.name === 'NotAllowedError') {
                errorMessage += 'Автозапуск аудио заблокирован браузером.';
            } else {
                errorMessage += error.message;
            }
            
            alert(errorMessage);
        });
    }
    
    // Обработчик завершения воспроизведения
    audioPlayer.onended = function() {
        console.log("Audio playback ended");
        button.classList.remove('playing');
        button.innerHTML = '▶';
        currentAudioButton = null;
        audioPlayer.currentTime = 0;
    };
    
    // Обработчик ошибок
    audioPlayer.onerror = function() {
        console.error('Ошибка загрузки аудио:', audioPlayer.error);
        button.classList.remove('playing');
        button.innerHTML = '▶';
        currentAudioButton = null;
        
        let errorMessage = 'Ошибка загрузки аудиофайла: ';
        switch(audioPlayer.error.code) {
            case MediaError.MEDIA_ERR_ABORTED:
                errorMessage += 'Загрузка прервана.';
                break;
            case MediaError.MEDIA_ERR_NETWORK:
                errorMessage += 'Ошибка сети.';
                break;
            case MediaError.MEDIA_ERR_DECODE:
                errorMessage += 'Ошибка декодирования. Файл поврежден или формат не поддерживается.';
                break;
            case MediaError.MEDIA_ERR_SRC_NOT_SUPPORTED:
                errorMessage += 'Формат аудио не поддерживается.';
                break;
            default:
                errorMessage += 'Неизвестная ошибка.';
        }
        
        alert(errorMessage);
    };
}

function safelyUpdateAudioButton(audioCell, audioPath) {
    // Кодируем путь для безопасного использования в URL
    const encodedPath = encodeURI(audioPath);
    
    // Создаем кнопку с правильным путем
    const playButton = document.createElement('button');
    playButton.className = 'play-btn';
    playButton.setAttribute('data-audio', encodedPath);
    playButton.textContent = '▶';
    
    // Добавляем обработчик события
    playButton.addEventListener('click', function() {
        playAudio(encodedPath, this);
    });
    
    // Очищаем ячейку и добавляем новую кнопку
    audioCell.innerHTML = '';
    audioCell.appendChild(playButton);
} 