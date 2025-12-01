<?php
require_once __DIR__ . '/config.php';

// Включаем отображение ошибок для отладки
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Функция для проверки существования таблиц (ТОЛЬКО ПРОВЕРКА, без создания)
function checkTables($pdo) {
    try {
        $pdo->query("SELECT 1 FROM words LIMIT 1");
        $pdo->query("SELECT 1 FROM sentences LIMIT 1");
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Функция для нормализации имени файла
function normalizeFileName($filename) {
    // Убираем расширение
    $pathInfo = pathinfo($filename);
    $name = $pathInfo['filename'];
    $extension = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';
    
    // Заменяем диакритические знаки и спецсимволы
    $transliteration = [
        'ć' => 'c', 'č' => 'c', 'ž' => 'z', 'š' => 's', 'đ' => 'dj', 
        'Ć' => 'C', 'Č' => 'C', 'Ž' => 'Z', 'Š' => 'S', 'Đ' => 'Dj',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'ђ' => 'dj', 
        'е' => 'e', 'ж' => 'z', 'з' => 'z', 'и' => 'i', 'ј' => 'j', 'к' => 'k', 
        'л' => 'l', 'љ' => 'lj', 'м' => 'm', 'н' => 'n', 'њ' => 'nj', 'о' => 'o', 
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'ћ' => 'c', 'у' => 'u', 
        'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'c', 'џ' => 'dz', 'ш' => 's',
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Ђ' => 'Dj',
        'Е' => 'E', 'Ж' => 'Z', 'З' => 'Z', 'И' => 'I', 'Ј' => 'J', 'К' => 'K',
        'Л' => 'L', 'Љ' => 'Lj', 'М' => 'M', 'Н' => 'N', 'Њ' => 'Nj', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'Ћ' => 'C', 'У' => 'U',
        'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'C', 'Џ' => 'Dz', 'Ш' => 'S'
    ];
    
    $name = strtr($name, $transliteration);
    
    // Убираем все не-ASCII символы и заменяем пробелы на подчеркивания
    $name = preg_replace('/[^a-zA-Z0-9_-]/', '_', $name);
    $name = preg_replace('/_{2,}/', '_', $name); // Заменяем множественные подчеркивания на одно
    $name = trim($name, '_');
    
    // Если имя стало пустым, используем временную метку
    if (empty($name)) {
        $name = 'audio_' . time();
    }
    
    return $name . $extension;
}

// Функция для загрузки файла с нормализацией имени
function uploadAudioFile($file, $type) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        error_log("Upload error: " . $file['error']);
        return null;
    }
    
    // Проверяем тип файла
    $allowedTypes = ['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg'];
    $fileType = mime_content_type($file['tmp_name']);
    
    error_log("File type detected: " . $fileType);
    error_log("File original name: " . $file['name']);
    
    if (!in_array($fileType, $allowedTypes)) {
        error_log("Invalid file type: " . $fileType);
        return null;
    }
    
    // Определяем папку для загрузки в зависимости от типа
    $uploadDir = '';
    $urlPath = '';
    
    if ($type === 'word') {
        $uploadDir = AUDIO_UPLOAD_DIR_WORDS;
        $urlPath = AUDIO_URL_WORDS;
    } elseif ($type === 'sentence') {
        $uploadDir = AUDIO_UPLOAD_DIR_SENTENCES;
        $urlPath = AUDIO_URL_SENTENCES;
    }
    
    // Нормализуем имя файла
    $normalizedName = normalizeFileName($file['name']);
    error_log("Normalized file name: " . $normalizedName);
    
    $filePath = $uploadDir . $normalizedName;
    $finalUrlPath = ''; // Будет хранить URL путь
    
    // Если файл с таким именем уже существует, добавляем суффикс
    $counter = 1;
    $pathInfo = pathinfo($normalizedName);
    $baseName = $pathInfo['filename'];
    $extension = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';
    
    while (file_exists($filePath)) {
        $newName = $baseName . '_' . $counter . $extension;
        $filePath = $uploadDir . $newName;
        $finalUrlPath = $urlPath . $newName;
        $counter++;
    }
    
    // Если не было конфликта имен
    if (empty($finalUrlPath)) {
        $finalUrlPath = $urlPath . $normalizedName;
    }
    
    error_log("Final file path: " . $filePath);
    error_log("Final URL path: " . $finalUrlPath);
    
    // Создаем папку если не существует
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
        error_log("Created directory: " . $uploadDir);
    }
    
    // Проверяем права доступа к папке
    if (!is_writable($uploadDir)) {
        error_log("Directory not writable: " . $uploadDir);
        return null;
    }
    
    // Перемещаем файл
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        error_log("File successfully uploaded to: " . $filePath);
        
        // Проверяем что файл действительно существует и доступен
        if (file_exists($filePath)) {
            error_log("File confirmed to exist at: " . $filePath);
            return $finalUrlPath; // Возвращаем URL путь, а не файловый путь
        } else {
            error_log("File move succeeded but file doesn't exist at destination: " . $filePath);
            return null;
        }
    } else {
        error_log("Failed to move uploaded file to: " . $filePath);
        error_log("Upload error: " . $file['error']);
        error_log("Temp file: " . $file['tmp_name']);
        return null;
    }
}

// Функции для работы со словами
function getWords($pdo) {
    // Проверяем существование таблицы перед запросом
    if (!checkTables($pdo)) {
        error_log("Tables don't exist, returning empty words array");
        return [];
    }
    
    $stmt = $pdo->query("SELECT * FROM words ORDER BY id DESC");
    $words = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Добавляем проверку существования аудиофайлов и корректные URL
    foreach ($words as &$word) {
        $word['audio_url'] = getAudioUrl($word['audio_path']);
        $word['audio_exists'] = checkAudioFile($word['audio_path']);
    }
    
    return $words;
}

function addWord($pdo, $latin, $cyrillic, $russian, $audio_path) {
    // Проверяем существование таблицы перед запросом
    if (!checkTables($pdo)) {
        error_log("Cannot add word: tables don't exist");
        return false;
    }
    
    $sql = "INSERT INTO words (latin, cyrillic, russian, audio_path) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$latin, $cyrillic, $russian, $audio_path]);
}

function deleteWord($pdo, $id) {
    // Проверяем существование таблицы перед запросом
    if (!checkTables($pdo)) {
        error_log("Cannot delete word: tables don't exist");
        return false;
    }
    
    // Сначала получаем путь к аудиофайлу
    $stmt = $pdo->prepare("SELECT audio_path FROM words WHERE id = ?");
    $stmt->execute([$id]);
    $word = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Удаляем аудиофайл - ИСПРАВЛЕННЫЙ КОД
    if ($word && $word['audio_path']) {
        $audioPath = $word['audio_path'];
        
        // Конвертируем URL путь в файловый путь
        if (strpos($audioPath, '/uploads/audio/') === 0) {
            $audioPath = $_SERVER['DOCUMENT_ROOT'] . $audioPath;
        }
        
        // Проверяем и удаляем файл
        if (file_exists($audioPath) && is_writable($audioPath)) {
            unlink($audioPath);
            error_log("Deleted audio file: " . $audioPath);
        } else {
            error_log("Audio file not found or not writable: " . $audioPath);
        }
    }
    
    // Удаляем запись из базы - ТОЛЬКО ОДНУ ЗАПИСЬ!
    $sql = "DELETE FROM words WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$id]);
    
    // Логируем операцию удаления
    error_log("Deleted word ID: " . $id . ", result: " . ($result ? 'success' : 'failure'));
    
    return $result;
}

// Функции для работы с предложениями
function getSentences($pdo) {
    // Проверяем существование таблицы перед запросом
    if (!checkTables($pdo)) {
        error_log("Tables don't exist, returning empty sentences array");
        return [];
    }
    
    $stmt = $pdo->query("SELECT * FROM sentences ORDER BY id DESC");
    $sentences = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Добавляем проверку существования аудиофайлов и корректные URL
    foreach ($sentences as &$sentence) {
        $sentence['audio_url'] = getAudioUrl($sentence['audio_path']);
        $sentence['audio_exists'] = checkAudioFile($sentence['audio_path']);
    }
    
    return $sentences;
}

function addSentence($pdo, $latin, $cyrillic, $russian, $audio_path) {
    // Проверяем существование таблицы перед запросом
    if (!checkTables($pdo)) {
        error_log("Cannot add sentence: tables don't exist");
        return false;
    }
    
    $sql = "INSERT INTO sentences (latin, cyrillic, russian, audio_path) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$latin, $cyrillic, $russian, $audio_path]);
}

function deleteSentence($pdo, $id) {
    // Проверяем существование таблицы перед запросом
    if (!checkTables($pdo)) {
        error_log("Cannot delete sentence: tables don't exist");
        return false;
    }
    
    // Сначала получаем путь к аудиофайлу
    $stmt = $pdo->prepare("SELECT audio_path FROM sentences WHERE id = ?");
    $stmt->execute([$id]);
    $sentence = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Удаляем аудиофайл - ИСПРАВЛЕННЫЙ КОД
    if ($sentence && $sentence['audio_path']) {
        $audioPath = $sentence['audio_path'];
        
        // Конвертируем URL путь в файловый путь
        if (strpos($audioPath, '/uploads/audio/') === 0) {
            $audioPath = $_SERVER['DOCUMENT_ROOT'] . $audioPath;
        }
        
        // Проверяем и удаляем файл
        if (file_exists($audioPath) && is_writable($audioPath)) {
            unlink($audioPath);
            error_log("Deleted audio file: " . $audioPath);
        } else {
            error_log("Audio file not found or not writable: " . $audioPath);
        }
    }
    
    // Удаляем запись из базы - ТОЛЬКО ОДНУ ЗАПИСЬ!
    $sql = "DELETE FROM sentences WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$id]);
    
    // Логируем операцию удаления
    error_log("Deleted sentence ID: " . $id . ", result: " . ($result ? 'success' : 'failure'));
    
    return $result;
}

// Функция для проверки существования аудиофайла
function checkAudioFile($audioPath) {
    if (empty($audioPath)) {
        return false;
    }
    
    // Если это URL путь, конвертируем в файловый путь
    if (strpos($audioPath, '/uploads/audio/') === 0) {
        $audioPath = $_SERVER['DOCUMENT_ROOT'] . $audioPath;
    }
    
    // Проверяем существование файла
    if (!file_exists($audioPath)) {
        error_log("Audio file not found: " . $audioPath);
        return false;
    }
    
    // Проверяем доступность файла для чтения
    if (!is_readable($audioPath)) {
        error_log("Audio file not readable: " . $audioPath);
        return false;
    }
    
    // Проверяем размер файла (должен быть больше 0)
    if (filesize($audioPath) === 0) {
        error_log("Audio file is empty: " . $audioPath);
        return false;
    }
    
    return true;
}

// Функция для получения корректного URL пути к аудио
function getAudioUrl($audioPath) {
    if (empty($audioPath)) {
        return '';
    }
    
    // Если это уже абсолютный файловый путь, конвертируем в URL
    if (strpos($audioPath, $_SERVER['DOCUMENT_ROOT']) === 0) {
        return str_replace($_SERVER['DOCUMENT_ROOT'], '', $audioPath);
    }
    
    // Если это относительный путь, добавляем слеш
    if (strpos($audioPath, '/') !== 0) {
        return '/' . $audioPath;
    }
    
    return $audioPath;
}
?>