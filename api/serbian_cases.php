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
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Content-Type');

// Функция для транслитерации кириллицы в латиницу
function cyrillicToLatin($text) {
    $cyr = [
        'а', 'б', 'в', 'г', 'д', 'ђ', 'е', 'ж', 'з', 'и', 'ј', 'к', 'л', 'љ', 'м', 'н', 'њ', 'о', 'п', 'р', 'с', 'т', 'ћ', 'у', 'ф', 'х', 'ц', 'ч', 'џ', 'ш',
        'А', 'Б', 'В', 'Г', 'Д', 'Ђ', 'Е', 'Ж', 'З', 'И', 'Ј', 'К', 'Л', 'Љ', 'М', 'Н', 'Њ', 'О', 'П', 'Р', 'С', 'Т', 'Ћ', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Џ', 'Ш'
    ];

    $lat = [
        'a', 'b', 'v', 'g', 'd', 'đ', 'e', 'ž', 'z', 'i', 'j', 'k', 'l', 'lj', 'm', 'n', 'nj', 'o', 'p', 'r', 's', 't', 'ć', 'u', 'f', 'h', 'c', 'č', 'dž', 'š',
        'A', 'B', 'V', 'G', 'D', 'Đ', 'E', 'Ž', 'Z', 'I', 'J', 'K', 'L', 'Lj', 'M', 'N', 'Nj', 'O', 'P', 'R', 'S', 'T', 'Ć', 'U', 'F', 'H', 'C', 'Č', 'Dž', 'Š'
    ];

    return str_replace($cyr, $lat, $text);
}

// Функция для транслитерации латиницы в кириллицу
function latinToCyrillic($text) {
    $lat = [
        'a', 'b', 'v', 'g', 'd', 'đ', 'e', 'ž', 'z', 'i', 'j', 'k', 'l', 'lj', 'm', 'n', 'nj', 'o', 'p', 'r', 's', 't', 'ć', 'u', 'f', 'h', 'c', 'č', 'dž', 'š',
        'A', 'B', 'V', 'G', 'D', 'Đ', 'E', 'Ž', 'Z', 'I', 'J', 'K', 'L', 'Lj', 'M', 'N', 'Nj', 'O', 'P', 'R', 'S', 'T', 'Ć', 'U', 'F', 'H', 'C', 'Č', 'Dž', 'Š'
    ];

    $cyr = [
        'а', 'б', 'в', 'г', 'д', 'ђ', 'е', 'ж', 'з', 'и', 'ј', 'к', 'л', 'љ', 'м', 'н', 'њ', 'о', 'п', 'р', 'с', 'т', 'ћ', 'у', 'ф', 'х', 'ц', 'ч', 'џ', 'ш',
        'А', 'Б', 'В', 'Г', 'Д', 'Ђ', 'Е', 'Ж', 'З', 'И', 'Ј', 'К', 'Л', 'Љ', 'М', 'Н', 'Њ', 'О', 'П', 'Р', 'С', 'Т', 'Ћ', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Џ', 'Ш'
    ];

    return str_replace($lat, $cyr, $text);
}

// Основная функция API
function getSerbianCases($word) {
    global $pdo;

    // Нормализуем слово (приводим к нижнему регистру)
    $word = trim($word);
    $originalWord = $word;

    // Определяем, в какой раскладке слово
    if (preg_match('/[а-шђјљњћџ]/iu', $word)) {
        // Слово в кириллице - транслитерируем в латиницу для поиска
        $latinWord = cyrillicToLatin($word);
        $searchWord = $latinWord;
    } else {
        // Слово в латинице
        $searchWord = $word;
        $cyrillicWord = latinToCyrillic($word);
    }

    // Ищем слово в базе данных - теперь без JOIN
    $stmt = $pdo->prepare("
        SELECT
            wc.* -- Берём все поля из word_cases, включая russian_translation
        FROM word_cases wc
        WHERE wc.base_word = ? OR wc.word_latin = ? OR wc.word_cyrillic = ?
        ORDER BY
            CASE wc.case_name
                WHEN 'nominativ' THEN 1
                WHEN 'genitiv' THEN 2
                WHEN 'dativ' THEN 3
                WHEN 'akuzativ' THEN 4
                WHEN 'instrumental' THEN 5
                WHEN 'lokativ' THEN 6
                WHEN 'vokativ' THEN 7
            END
    ");

    $stmt->execute([$searchWord, $searchWord, $originalWord]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        return ['success' => false, 'error' => 'Слово не найдено в базе данных. Попробуйте: student, knjiga, mesto, more, žena, profesor'];
    }

    // Форматируем результат
    $baseWord = $results[0]['base_word'];
    $gender = $results[0]['gender'];
    // russian_translation берём из первой строки (он должен быть одинаковым для всех форм одного слова)
    $russianTranslation = $results[0]['russian_translation'];

    $cases = [];
    foreach ($results as $row) {
        $cases[] = [
            'case_name' => $row['case_name'],
            'case_name_cyrillic' => $row['case_name_cyrillic'],
            'word_latin' => $row['word_latin'],
            'word_cyrillic' => $row['word_cyrillic'],
            'russian_translation' => $row['russian_translation'] // Берём из базы
        ];
    }

    return [
        'success' => true,
        'original_word' => $originalWord,
        'base_word' => $baseWord,
        'gender' => $gender,
        'russian_translation' => $russianTranslation, // Перевод для базового слова
        'cases' => $cases
    ];
}

// Обработка запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $word = $input['word'] ?? '';

    if (empty($word)) {
        echo json_encode(['success' => false, 'error' => 'Не указано слово'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $result = getSerbianCases($word);
    echo json_encode($result, JSON_UNESCAPED_UNICODE);

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $word = $_GET['word'] ?? '';

    if (empty($word)) {
        echo json_encode(['success' => false, 'error' => 'Не указано слово'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $result = getSerbianCases($word);
    echo json_encode($result, JSON_UNESCAPED_UNICODE);

} else {
    echo json_encode(['success' => false, 'error' => 'Метод не поддерживается'], JSON_UNESCAPED_UNICODE);
}
?>