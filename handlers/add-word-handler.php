<?php
require_once __DIR__ . '/../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $base_word = trim($_POST['base_word']);
    $russian_translation = trim($_POST['russian_translation']);
    $gender = $_POST['gender'];
    $cases = $_POST['cases'];
    
    // Валидация
    if (empty($base_word) || empty($russian_translation) || empty($gender)) {
        $_SESSION['error'] = 'Все основные поля должны быть заполнены';
        header('Location: ../index.php?page=admin-words');
        exit();
    }
    
    // Проверяем все падежные формы
    foreach ($cases as $case => $forms) {
        if (empty($forms['latin']) || empty($forms['cyrillic'])) {
            $_SESSION['error'] = 'Все падежные формы должны быть заполнены';
            header('Location: ../index.php?page=admin-words');
            exit();
        }
    }
    
    try {
        // Начинаем транзакцию
        $pdo->beginTransaction();
        
        // Добавляем перевод
        $stmt = $pdo->prepare("INSERT IGNORE INTO word_relations (serbian_word, russian_translation) VALUES (?, ?)");
        $stmt->execute([$base_word, $russian_translation]);
        
        // Добавляем падежные формы
        $case_names = [
            'nominativ' => 'Именительный',
            'genitiv' => 'Родительный',
            'dativ' => 'Дательный',
            'akuzativ' => 'Винительный',
            'instrumental' => 'Творительный',
            'lokativ' => 'Предложный',
            'vokativ' => 'Звательный'
        ];
        
        $stmt = $pdo->prepare("
            INSERT IGNORE INTO word_cases 
            (base_word, word_latin, word_cyrillic, case_name, case_name_cyrillic, gender) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($cases as $case_key => $forms) {
            $stmt->execute([
                $base_word,
                $forms['latin'],
                $forms['cyrillic'],
                $case_key,
                $case_names[$case_key],
                $gender
            ]);
        }
        
        $pdo->commit();
        
        $_SESSION['success'] = "Слово '$base_word' успешно добавлено в базу данных!";
        
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = 'Ошибка при добавлении слова: ' . $e->getMessage();
    }
    
    header('Location: ../index.php?page=admin-words');
    exit();
}
?>