<?php
require_once '../config/config.php';

// Если auth.php существует, подключаем его
if (file_exists('../includes/auth.php')) {
    require_once '../includes/auth.php';
} else {
    // Заглушки функций если auth.php нет
    function isLoggedIn() { return true; }
}

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

function getAllWords() {
    global $pdo;

    try {
        // Запрос теперь не нуждается в JOIN с word_relations
        $stmt = $pdo->query("
            SELECT DISTINCT
                base_word,
                word_latin,
                word_cyrillic,
                gender,
                russian_translation -- Берём перевод из word_cases
            FROM word_cases
            WHERE case_name = 'nominativ'
            ORDER BY base_word
        ");

        $words = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // russian_translation уже есть в $words, дополнительный запрос не нужен

        return [
            'success' => true,
            'words' => $words,
            'count' => count($words)
        ];

    } catch (Exception $e) {
        error_log("Database error in words_list.php: " . $e->getMessage());
        return [
            'success' => false,
            'error' => 'Database error: ' . $e->getMessage()
        ];
    }
}

// Обработка запроса
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = getAllWords();
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Method not allowed'
    ], JSON_UNESCAPED_UNICODE);
}
?>