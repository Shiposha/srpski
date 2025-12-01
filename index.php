<?php
require_once 'config/config.php';
require_once 'config/functions.php';
require_once 'includes/auth.php';

$requestUri = $_SERVER['REQUEST_URI'];
$apiPath = '/srb/api/'; // Замени на твой путь

if (strpos($requestUri, $apiPath) !== false) {
    // Определяем реальный путь к файлу API
    $apiFile = __DIR__ . str_replace('/srb', '', $requestUri);
    
    if (file_exists($apiFile)) {
        require_once $apiFile;
        exit;
    }
}

// Определяем активную страницу из GET параметра или по умолчанию
$page = isset($_GET['page']) ? $_GET['page'] : 'alphabet';
$allowed_pages = ['alphabet','cases','pronouns','numbers','particles','adjectives','adverbs','nouns','verb-biti','time','words','sentences','serbskiy-za-30-dney','govori-srpski','138-verbs','ucimo-srpski-notebook','ucimo-srpski-1','ucimo-srpski-2','admin-words','simulator'];

// Если запрошена несуществующая страница - показываем алфавит
if (!in_array($page, $allowed_pages)) {
    $page = 'alphabet';
}

// Подключаем обработчики если нужно
if ($page == 'words' && ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['delete_word']))) {
    require_once 'handlers/words-handler.php';
}

if ($page == 'sentences' && ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['delete_sentence']))) {
    require_once 'handlers/sentences-handler.php';
}

// Получаем данные для страниц
$words = getWords($pdo);
$sentences = getSentences($pdo);

// Функция для получения списка MP3 файлов
function getAudioFiles($folder) {
    $audioFiles = [];
    $audioDir = 'uploads/audio/' . $folder . '/';
    if (is_dir($audioDir)) {
        $files = scandir($audioDir);
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'mp3') {
                $audioFiles[] = $audioDir . $file;
            }
        }
        sort($audioFiles);
    }
    return $audioFiles;
}

// Получаем список MP3 файлов для страниц
$ucimoSrpski1AudioFiles = getAudioFiles('ucimo_srpski_1');
$ucimoSrpski2AudioFiles = getAudioFiles('ucimo_srpski_2');

// СОХРАНЯЕМ ОБРАТНУЮ СОВМЕСТИМОСТЬ ДЛЯ СТРАНИЦЫ "УЧИМ СЕРБСКИЙ 1"
// Эта переменная используется в pages/ucimo-srpski-1.php
$ucimoSrpskiAudioFiles = $ucimoSrpski1AudioFiles;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Изучение сербского языка</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'pages/header.php'; ?>
    
    <div class="container">
        <?php
        // Подключаем запрошенную страницу
        include "pages/{$page}.php";
        ?>
    </div>
    
    <?php include 'pages/footer.php'; ?>

    <!-- Скрытый аудиоплеер -->
    <audio id="audio-player" style="display: none;"></audio>

<script src="assets/js/script.js"></script>
</body>
</html>