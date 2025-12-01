<?php
require_once __DIR__ . '/../config/config.php';

// Обработка добавления слова
if (isset($_POST['add_word'])) {
    $latin = $_POST['word_latin'];
    $cyrillic = $_POST['word_cyrillic'];
    $russian = $_POST['word_russian'];
    $audio_path = null;
    
    // Обрабатываем загрузку аудиофайла
    if (isset($_FILES['word_audio_file']) && $_FILES['word_audio_file']['error'] === UPLOAD_ERR_OK) {
        $audio_path = uploadAudioFile($_FILES['word_audio_file'], 'word');
    }
    
    addWord($pdo, $latin, $cyrillic, $russian, $audio_path);
    header("Location: ?page=words");
    exit();
}

// Обработка удаления слова
if (isset($_GET['delete_word'])) {
    $id = $_GET['delete_word'];
    deleteWord($pdo, $id);
    header("Location: ?page=words");
    exit();
}
?>