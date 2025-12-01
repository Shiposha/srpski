<?php
// Обработка добавления предложения
if (isset($_POST['add_sentence'])) {
    $latin = $_POST['sentence_latin'];
    $cyrillic = $_POST['sentence_cyrillic'];
    $russian = $_POST['sentence_russian'];
    $audio_path = null;
    
    // Обрабатываем загрузку аудиофайла
    if (isset($_FILES['sentence_audio_file']) && $_FILES['sentence_audio_file']['error'] === UPLOAD_ERR_OK) {
        $audio_path = uploadAudioFile($_FILES['sentence_audio_file'], 'sentence');
    }
    
    addSentence($pdo, $latin, $cyrillic, $russian, $audio_path);
    header("Location: ?page=sentences");
    exit();
}

// Обработка удаления предложения
if (isset($_GET['delete_sentence'])) {
    $id = $_GET['delete_sentence'];
    deleteSentence($pdo, $id);
    header("Location: ?page=sentences");
    exit();
}
?>