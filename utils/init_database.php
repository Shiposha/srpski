<?php
require_once 'config.php';

try {
    createTables($pdo);
    echo "База данных успешно инициализирована!";
} catch (Exception $e) {
    echo "Ошибка при инициализации базы данных: " . $e->getMessage();
}
?>