<section id="ucimo-srpski-1" class="page active">
    <!-- Аудиоплеер для уроков - КОМПАКТНАЯ ВЕРСИЯ -->
    <div class="audio-player-section compact">
        <div class="audio-controls-compact">
            <select id="lesson-select" class="lesson-select">
                <option value="">Выберите урок для прослушивания</option>
                <?php foreach ($ucimoSrpski1AudioFiles as $index => $audioFile): ?>
                    <?php 
                    $fileName = basename($audioFile);
                    $lessonNumber = $index + 1;
                    $displayName = "Урок " . $lessonNumber . " - " . pathinfo($fileName, PATHINFO_FILENAME);
                    ?>
                    <option value="<?= htmlspecialchars($audioFile) ?>"><?= htmlspecialchars($displayName) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="player-buttons">
                <button id="play-pause-lesson" class="play-pause-lesson-btn" disabled>▶</button>
                <button id="stop-lesson" class="stop-lesson-btn" disabled>⏹</button>
            </div>
        </div>
        <div class="audio-progress-compact">
            <progress id="audio-progress" value="0" max="100"></progress>
            <div class="time-display-compact">
                <span id="current-time">0:00</span> / <span id="duration">0:00</span>
            </div>
        </div>
    </div>

    <!-- PDF просмотрщик -->
    <div class="pdf-viewer-section">
        <div class="pdf-container">
            <embed src="uploads/docs/ucimo_srpski_1/Učimo srpski 1.pdf" 
                   type="application/pdf" 
                   class="pdf-viewer">
            <div class="pdf-fallback">
                <p>Если PDF не отображается, вы можете <a href="uploads/docs/ucimo_srpski_1/Učimo srpski 1.pdf" target="_blank">скачать файл</a>.</p>
            </div>
        </div>
    </div>
    
    <!-- Кнопка просмотра PDF словаря -->
    <h3>Словарь "Учим Сербский 1"</h3>
    
    <div class="pdf-actions">
        <a href="uploads/docs/ucimo_srpski_1/Ruski.pdf" target="_blank" class="pdf-btn primary-btn">
            👁️ Просмотреть PDF в новом окне
        </a>
        
        <a href="uploads/docs/ucimo_srpski_1/Ruski.pdf" download class="pdf-btn secondary-btn">
            ⬇️ Скачать PDF
        </a>
    </div> 
</section>

<script src="assets/js/ios-pdf-notice.js"></script>