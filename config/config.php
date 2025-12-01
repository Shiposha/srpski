<?php
session_start();

$host = 'localhost';
$dbname = 'serbian_language';
$username = 'root';
$password = 'Pogfpogf123!';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // В режиме без БД продолжаем работу
    error_log("Database connection error: " . $e->getMessage());
}

// Абсолютные пути для загрузки аудиофайлов
define('AUDIO_UPLOAD_DIR_WORDS', $_SERVER['DOCUMENT_ROOT'] . '/uploads/audio/words/');
define('AUDIO_UPLOAD_DIR_SENTENCES', $_SERVER['DOCUMENT_ROOT'] . '/uploads/audio/sentences/');

// URL пути для доступа к файлам через браузер
define('AUDIO_URL_WORDS', '/uploads/audio/words/');
define('AUDIO_URL_SENTENCES', '/uploads/audio/sentences/');

// Создаем папки для загрузок, если они не существуют
if (!file_exists(AUDIO_UPLOAD_DIR_WORDS)) {
    mkdir(AUDIO_UPLOAD_DIR_WORDS, 0777, true);
}
if (!file_exists(AUDIO_UPLOAD_DIR_SENTENCES)) {
    mkdir(AUDIO_UPLOAD_DIR_SENTENCES, 0777, true);
}
?>