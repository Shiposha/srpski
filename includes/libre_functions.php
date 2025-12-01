<?php
function libreTranslate($text, $sourceLang = 'sr', $targetLang = 'ru') {
    // Только РАБОЧИЕ серверы (проверены 18.11.2025)
    $servers = [
        [
            'name' => 'libretranslate.de',
            'url' => 'https://libretranslate.com/translate',
            'weight' => 10 // Приоритет
        ]
        // [
        //     'name' => 'libretranslate.woody.so',
        //     'url' => 'https://libretranslate.woody.so/translate',
        //     'weight' => 8
        // ],
        // [
        //     'name' => 'trans.zillyhuhn.com',
        //     'url' => 'https://trans.zillyhuhn.com/translate',
        //     'weight' => 6
        // ]
    ];
    
    // Перемешиваем серверы по приоритету
    usort($servers, function($a, $b) {
        return $b['weight'] - $a['weight'];
    });
    
    foreach ($servers as $server) {
        try {
            $data = [
                'q' => $text,
                'source' => $sourceLang,
                'target' => $targetLang,
                'format' => 'text'
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $server['url']);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 12);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            $curlInfo = curl_getinfo($ch);
            curl_close($ch);
            
            // ДЕТАЛЬНОЕ ЛОГИРОВАНИЕ
            error_log("=== LibreTranslate Debug ===");
            error_log("Попытка: {$server['name']}");
            error_log("URL: {$server['url']}");
            error_log("Данные: " . json_encode($data));
            error_log("Ответ: $response");
            error_log("HTTP код: $httpCode");
            error_log("CURL ошибка: $error");
            error_log("Время: {$curlInfo['total_time']} сек");
            
            if ($httpCode === 200 && $response) {
                $result = json_decode($response, true);
                
                if (json_last_error() === JSON_ERROR_NONE) {
                    // Стандартный формат ответа
                    if (isset($result['translatedText']) && !empty($result['translatedText'])) {
                        error_log("✅ Успешный перевод с {$server['name']}: " . $result['translatedText']);
                        return $result['translatedText'];
                    }
                    
                    // Альтернативные форматы
                    if (isset($result['translated_text']) && !empty($result['translated_text'])) {
                        error_log("✅ Успешный перевод (альтернативный формат) с {$server['name']}: " . $result['translated_text']);
                        return $result['translated_text'];
                    }
                    
                    if (isset($result['translation']) && !empty($result['translation'])) {
                        error_log("✅ Успешный перевод (формат RapidAPI) с {$server['name']}: " . $result['translation']);
                        return $result['translation'];
                    }
                } else {
                    error_log("❌ Ошибка парсинга JSON: " . json_last_error_msg());
                }
            }
            
            // Если сервер вернул ошибку 429 (слишком много запросов) - пропускаем
            if ($httpCode === 429) {
                error_log("⚠️ Сервер {$server['name']} вернул 429 Too Many Requests");
                continue;
            }
            
        } catch (Exception $e) {
            error_log("❌ Исключение при обращении к {$server['name']}: " . $e->getMessage());
            continue;
        }
    }
    
    error_log("❌ Все серверы недоступны для слова: $text");
    return null;
}

// Функция для проверки доступности интернета
function hasInternetConnection() {
    static $connectionStatus = null;
    
    if ($connectionStatus === null) {
        $testUrls = [
            'https://google.com',
            'https://libretranslate.de'
        ];
        
        foreach ($testUrls as $url) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_NOBODY, true); // Проверяем только заголовки
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode === 200) {
                $connectionStatus = true;
                return true;
            }
        }
        
        $connectionStatus = false;
    }
    
    return $connectionStatus;
}
?>