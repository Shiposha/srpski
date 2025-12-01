<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../includes/libre_functions.php';

// Проверяем интернет
$internetAvailable = hasInternetConnection();

// Тестируем перевод
$testWord = 'knjiga';
$translation = $internetAvailable ? libreTranslate($testWord, 'sr', 'ru') : null;

echo json_encode([
    'status' => 'debug',
    'server_time' => date('Y-m-d H:i:s'),
    'internet_available' => $internetAvailable,
    'test_word' => $testWord,
    'translation' => $translation,
    'servers_tested' => [
        'libretranslate.com' => testServer('https://libretranslate.com'),
        'libretranslate.woody.so' => testServer('https://libretranslate.woody.so'),
        'trans.zillyhuhn.com' => testServer('https://trans.zillyhuhn.com')
    ]
], JSON_UNESCAPED_UNICODE);

function testServer($url) {
    $ch = curl_init($url . '/spec');
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    return [
        'reachable' => ($httpCode === 200),
        'http_code' => $httpCode,
        'error' => $error
    ];
}
?>