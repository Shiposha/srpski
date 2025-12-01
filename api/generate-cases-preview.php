<?php
require_once '../config/config.php';
require_once '../includes/morphology.php';

header('Content-Type: application/json');

// Включаем отладку
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $word = $input['word'] ?? '';
    $gender = $input['gender'] ?? 'm';
    
    if (empty($word)) {
        echo json_encode(['success' => false, 'error' => 'Введите слово']);
        exit;
    }
    
    try {
        $result = generateSerbianCases($word, $gender, 'предпросмотр');
        
        if ($result && isset($result['cases'])) {
            echo json_encode([
                'success' => true,
                'cases' => $result['cases']
            ], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'Не удалось сгенерировать падежи'
            ], JSON_UNESCAPED_UNICODE);
        }
    } catch (Exception $e) {
        error_log("Morphology error: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'error' => 'Ошибка генерации: ' . $e->getMessage()
        ], JSON_UNESCAPED_UNICODE);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Метод не поддерживается']);
}
?>