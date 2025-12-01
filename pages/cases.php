<section id="cases" class="page active">
    <h2>Сербские падежи</h2>
    <div class="case-info">
        <h3>Объяснение падежей</h3>
        <div class="case-explanation">
            <div class="case-item">
                <h4>1. Именительный (Nominativ)</h4>
                <p><strong>Вопросы:</strong> ко? шта? (кто? что?)</p>
                <p><strong>Пример:</strong> Ово је <strong>студент</strong>. (Это студент.)</p>
            </div>
            
            <div class="case-item">
                <h4>2. Родительный (Genitiv)</h4>
                <p><strong>Вопросы:</strong> од кога? од чега? (от кого? от чего?)</p>
                <p><strong>Пример:</strong> Књига <strong>студента</strong>. (Книга студента.)</p>
            </div>
            
            <div class="case-item">
                <h4>3. Дательный (Dativ)</h4>
                <p><strong>Вопросы:</strong> коме? чему? (кому? чему?)</p>
                <p><strong>Пример:</strong> Дајем књигу <strong>студенту</strong>. (Я даю книгу студенту.)</p>
            </div>
            
            <div class="case-item">
                <h4>4. Винительный (Akuzativ)</h4>
                <p><strong>Вопросы:</strong> кога? шта? (кого? что?)</p>
                <p><strong>Пример:</strong> Видим <strong>студента</strong>. (Я вижу студента.)</p>
            </div>

            <div class="case-item">
                <h4>7. Звательный (Vokativ)</h4>
                <p><strong>Использование:</strong> для обращения</p>
                <p><strong>Пример:</strong> <strong>Студенте</strong>, дођи овамо! (Студент, иди сюда!)</p>
            </div>
            
            <div class="case-item">
                <h4>5. Творительный (Instrumental)</h4>
                <p><strong>Вопросы:</strong> с ким? чиме? (с кем? с чем?)</p>
                <p><strong>Пример:</strong> Разговарам са <strong>студентом</strong>. (Я разговариваю со студентом.)</p>
            </div>
            
            <div class="case-item">
                <h4>6. Предложный (Lokativ)</h4>
                <p><strong>Вопросы:</strong> о коме? о чему? (о ком? о чём?)</p>
                <p><strong>Пример:</strong> Говорим о <strong>студенту</strong>. (Мы говорим о студенте.)</p>
            </div>
        </div>
    </div>

    <br>
    <p>Выберите слово из списка, чтобы увидеть все его падежные формы.</p>
    
    <div class="case-form-container">
        <div class="form-group">
            <label for="word-select">Выберите слово:</label>
            <select id="word-select" class="word-select">
                <option value="">-- Выберите слово --</option>
                <!-- Слова будут загружены через JavaScript -->
            </select>
        </div>
        
        <div class="word-count" id="word-count" style="margin-top: 10px; font-size: 14px; color: #666;">
            Загрузка слов...
        </div>
    </div>

    <div id="case-results" style="display: none;">
        <h3>Падежные формы слова: "<span id="word-title"></span>"</h3>
        <div id="word-info" class="word-info" style="margin-bottom: 20px;"></div>
        
        <table class="case-table">
            <thead>
                <tr>
                    <th>Падеж</th>
                    <th>Вопрос</th>
                    <th>Сербский (латиница)</th>
                    <th>Сербский (кириллица)</th>
                </tr>
            </thead>
            <tbody id="case-table-body">
                <!-- Здесь будут динамически добавляться строки с падежами -->
            </tbody>
        </table>
        
        <div class="case-actions" style="margin-top: 20px;">
            <button id="show-all-words" class="secondary-btn">Показать все слова</button>
            <?php if (isAdmin()): ?>
            <a href="?page=admin-words" class="secondary-btn">Добавить новое слово</a>
            <?php endif; ?>
        </div>
    </div>

    <div id="case-error" class="error-message" style="display: none; margin: 20px 0;"></div>

    <div class="all-words-section" id="all-words-section" style="display: none; margin-top: 30px;">
        <h3>Все слова в базе данных</h3>
        <div id="all-words-list" class="all-words-list">
            <!-- Список всех слов будет загружен здесь -->
        </div>
    </div>
</section>