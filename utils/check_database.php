<?php
require_once 'config.php';

echo "<h2>Проверка базы данных</h2>";

try {
    // Проверяем существование таблиц
    $tables = ['word_cases', 'word_relations', 'words', 'sentences'];
    
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        $exists = $stmt->fetch() ? '✅ СУЩЕСТВУЕТ' : '❌ ОТСУТСТВУЕТ';
        echo "<p>Таблица <strong>$table</strong>: $exists</p>";
    }
    
    // Проверяем данные в word_cases
    echo "<h3>Данные в таблице word_cases:</h3>";
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM word_cases");
    $count = $stmt->fetch()['count'];
    echo "<p>Записей в word_cases: <strong>$count</strong></p>";
    
    if ($count > 0) {
        $stmt = $pdo->query("SELECT DISTINCT base_word FROM word_cases LIMIT 10");
        $words = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "<p>Примеры слов: " . implode(', ', $words) . "</p>";
    }
    
    // Проверяем API endpoint
    echo "<h3>Проверка API:</h3>";
    $apiUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/api/words_list.php';
    echo "<p>API URL: <a href='$apiUrl' target='_blank'>$apiUrl</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Ошибка базы данных: " . $e->getMessage() . "</p>";
}
?>