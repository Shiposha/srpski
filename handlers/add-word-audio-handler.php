<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/functions.php';

// Включаем отображение ошибок для отладки
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Логируем входящие данные для отладки
error_log("=== ADD WORD AUDIO HANDLER ===");
error_log("Request method: " . $_SERVER['REQUEST_METHOD']);
error_log("POST data: " . print_r($_POST, true));
error_log("FILES data: " . print_r($_FILES, true));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Проверяем наличие необходимых данных
    if (!isset($_POST['word_id']) || !isset($_FILES['audio_file'])) {
        error_log("Missing required data: word_id or audio_file");
        echo json_encode(['success' => false, 'error' => 'Недостаточно данных: word_id или audio_file отсутствуют']);
        exit;
    }
    
    $wordId = (int)$_POST['word_id'];
    $audioFile = $_FILES['audio_file'];
    
    error_log("Processing word ID: " . $wordId);
    error_log("Audio file: " . print_r($audioFile, true));
    
    // Проверяем ошибки загрузки файла
    if ($audioFile['error'] !== UPLOAD_ERR_OK) {
        $uploadErrors = [
            UPLOAD_ERR_INI_SIZE => 'Файл слишком большой',
            UPLOAD_ERR_FORM_SIZE => 'Файл слишком большой',
            UPLOAD_ERR_PARTIAL => 'Файл загружен частично',
            UPLOAD_ERR_NO_FILE => 'Файл не был загружен',
            UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка',
            UPLOAD_ERR_CANT_WRITE => 'Ошибка записи на диск',
            UPLOAD_ERR_EXTENSION => 'Расширение PHP остановило загрузку'
        ];
        $errorMsg = $uploadErrors[$audioFile['error']] ?? 'Неизвестная ошибка загрузки';
        error_log("Upload error: " . $errorMsg);
        echo json_encode(['success' => false, 'error' => 'Ошибка загрузки файла: ' . $errorMsg]);
        exit;
    }
    
    // Проверяем тип файла
    $allowedTypes = ['audio/mpeg', 'audio/mp3'];
    $fileType = mime_content_type($audioFile['tmp_name']);
    
    error_log("File type: " . $fileType);
    error_log("File size: " . $audioFile['size']);
    
    if (!in_array($fileType, $allowedTypes)) {
        error_log("Invalid file type: " . $fileType);
        echo json_encode(['success' => false, 'error' => 'Недопустимый тип файла. Разрешены только MP3 файлы. Получен: ' . $fileType]);
        exit;
    }
    
    // Проверяем размер файла (максимум 10MB)
    $maxFileSize = 10 * 1024 * 1024; // 10MB в байтах
    if ($audioFile['size'] > $maxFileSize) {
        error_log("File too large: " . $audioFile['size']);
        echo json_encode(['success' => false, 'error' => 'Файл слишком большой. Максимальный размер: 10MB']);
        exit;
    }
    
    // Загружаем аудиофайл
    error_log("Calling uploadAudioFile function");
    $audioPath = uploadAudioFile($audioFile, 'word');
    
    if (!$audioPath) {
        error_log("uploadAudioFile returned false or null");
        echo json_encode(['success' => false, 'error' => 'Ошибка при загрузке файла на сервер']);
        exit;
    }
    
    error_log("Audio file uploaded to: " . $audioPath);
    
    // Обновляем запись в базе данных
    try {
        // Сначала проверяем существование слова
        $checkStmt = $pdo->prepare("SELECT id FROM words WHERE id = ?");
        $checkStmt->execute([$wordId]);
        $wordExists = $checkStmt->fetch();
        
        if (!$wordExists) {
            error_log("Word not found with ID: " . $wordId);
            // Удаляем загруженный файл если слово не найдено
            if (file_exists($audioPath)) {
                unlink($audioPath);
            }
            echo json_encode(['success' => false, 'error' => 'Слово не найдено в базе данных']);
            exit;
        }
        
        // Обновляем аудио путь
        $updateStmt = $pdo->prepare("UPDATE words SET audio_path = ? WHERE id = ?");
        $result = $updateStmt->execute([$audioPath, $wordId]);
        
        error_log("Database update result: " . ($result ? 'success' : 'failure'));
        error_log("Rows affected: " . $updateStmt->rowCount());
        
        if ($result && $updateStmt->rowCount() > 0) {
            error_log("Successfully updated word audio");
            
            // Кодируем путь для безопасного использования в URL
            $encodedAudioPath = htmlspecialchars($audioPath);
            
            echo json_encode([
                'success' => true, 
                'audio_path' => $encodedAudioPath,
                'raw_audio_path' => $audioPath,
                'message' => 'Аудиофайл успешно добавлен'
            ]);
        } else {
            error_log("Database update failed or no rows affected");
            // Удаляем загруженный файл если обновление БД не удалось
            if (file_exists($audioPath)) {
                unlink($audioPath);
                error_log("Deleted uploaded file due to database failure");
            }
            echo json_encode(['success' => false, 'error' => 'Ошибка при обновлении базы данных. Возможно, слово не найдено.']);
        }
        
    } catch (Exception $e) {
        error_log("Database exception: " . $e->getMessage());
        // Удаляем загруженный файл если произошла ошибка
        if (file_exists($audioPath)) {
            unlink($audioPath);
            error_log("Deleted uploaded file due to exception");
        }
        echo json_encode(['success' => false, 'error' => 'Ошибка базы данных: ' . $e->getMessage()]);
    }
    
} else {
    error_log("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
    echo json_encode(['success' => false, 'error' => 'Неверный метод запроса. Требуется POST.']);
}
?>