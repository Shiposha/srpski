<?php
// ОБРАБОТКА CORS ДЛЯ ВСЕХ ЗАПРОСОВ В САМОМ НАЧАЛЕ
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Accept');
header('Access-Control-Max-Age: 86400');

// Обработка OPTIONS запросов (предзапросы CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once '../config/config.php';
require_once '../includes/libre_functions.php';

header('Content-Type: application/json');

// Теперь разрешаем GET запросы для тестирования
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $word = $_GET['word'] ?? 'knjiga';
    $translation = libreTranslate($word, 'sr', 'ru');
    
    echo json_encode([
        'success' => $translation !== null,
        'translation' => $translation,
        'original' => $word,
        'method' => 'GET'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $word = $input['word'] ?? '';
    
    if (empty($word)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Слово не указано']);
        exit;
    }
    
    // Ограничиваем частоту запросов (1 запрос в 3 секунды)
    session_start();
    $lastRequest = $_SESSION['last_libre_request'] ?? 0;
    
    if (time() - $lastRequest < 3) {
        http_response_code(429);
        echo json_encode(['success' => false, 'error' => 'Подождите 3 секунды между запросами']);
        exit;
    }
    
    $_SESSION['last_libre_request'] = time();
    
    try {
        $translation = libreTranslate($word, 'sr', 'ru');
        
        if ($translation) {
            echo json_encode([
                'success' => true,
                'translation' => $translation,
                'original' => $word
            ], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(503);
            echo json_encode([
                'success' => false,
                'error' => 'Не удалось перевести слово. Все серверы перевода недоступны.'
            ]);
        }
    } catch (Exception $e) {
        error_log("LibreTranslate API error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Внутренняя ошибка сервера: ' . $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Метод не поддерживается']);
}
?>