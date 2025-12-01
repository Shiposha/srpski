<?php
/**
 * Автоматическая генерация сербских падежей по правилам
 * Поддерживает все 3 рода и основные типы окончаний
 */

// Основная функция генерации падежей
function generateSerbianCases($baseWord, $gender, $russianTranslation = '') {
    $baseWord = trim(strtolower($baseWord));
    $gender = strtolower($gender);
    
    // Список неправильных слов с исключениями
    $irregularWords = getIrregularWords();
    
    // Проверяем, есть ли слово в списке исключений
    if (isset($irregularWords[$baseWord])) {
        return $irregularWords[$baseWord];
    }
    
    // Определяем тип слова по окончанию
    $wordType = determineWordType($baseWord, $gender);
    
    // Генерируем падежи в зависимости от типа
    switch ($wordType) {
        case 'm_consonant': // Мужской род на согласный
            return generateMasculineConsonant($baseWord, $gender, $russianTranslation);
        case 'm_vowel': // Мужской род на гласную (редко)
            return generateMasculineVowel($baseWord, $gender, $russianTranslation);
        case 'f_a': // Женский род на -a
            return generateFeminineA($baseWord, $gender, $russianTranslation);
        case 'f_consonant': // Женский род на согласный
            return generateFeminineConsonant($baseWord, $gender, $russianTranslation);
        case 'n_o_e': // Средний род на -o, -e
            return generateNeuterOE($baseWord, $gender, $russianTranslation);
        default:
            // Если тип не определен, возвращаем базовую форму для всех падежей
            return generateFallback($baseWord, $gender, $russianTranslation);
    }
}

// Определение типа слова по окончанию и роду
function determineWordType($baseWord, $gender) {
    $lastChar = mb_substr($baseWord, -1);
    
    switch ($gender) {
        case 'm':
            if (in_array($lastChar, ['a', 'e', 'i', 'o', 'u'])) {
                return 'm_vowel';
            }
            return 'm_consonant';
        case 'f':
            if ($lastChar === 'a') {
                return 'f_a';
            }
            return 'f_consonant';
        case 'n':
            if (in_array($lastChar, ['o', 'e'])) {
                return 'n_o_e';
            }
            return 'n_other';
        default:
            return 'unknown';
    }
}

// Генерация для мужского рода на согласный (student, profesor)
function generateMasculineConsonant($baseWord, $gender, $russianTranslation) {
    $stem = getStem($baseWord, 'm_consonant');
    
    return [
        'base_word' => $baseWord,
        'gender' => $gender,
        'russian_translation' => $russianTranslation,
        'cases' => [
            'nominativ' => [$baseWord, latinToCyrillic($baseWord)],
            'genitiv' => [$stem . 'a', latinToCyrillic($stem . 'a')],
            'dativ' => [$stem . 'u', latinToCyrillic($stem . 'u')],
            'akuzativ' => [$stem . 'a', latinToCyrillic($stem . 'a')],
            'instrumental' => [$stem . 'om', latinToCyrillic($stem . 'om')],
            'lokativ' => [$stem . 'u', latinToCyrillic($stem . 'u')],
            'vokativ' => [$stem . 'e', latinToCyrillic($stem . 'e')]
        ]
    ];
}

// Генерация для женского рода на -a (knjiga, žena)
function generateFeminineA($baseWord, $gender, $russianTranslation) {
    $stem = mb_substr($baseWord, 0, -1); // Убираем последнюю 'a'
    
    return [
        'base_word' => $baseWord,
        'gender' => $gender,
        'russian_translation' => $russianTranslation,
        'cases' => [
            'nominativ' => [$baseWord, latinToCyrillic($baseWord)],
            'genitiv' => [$stem . 'e', latinToCyrillic($stem . 'e')],
            'dativ' => [$stem . 'i', latinToCyrillic($stem . 'i')],
            'akuzativ' => [$stem . 'u', latinToCyrillic($stem . 'u')],
            'instrumental' => [$stem . 'om', latinToCyrillic($stem . 'om')],
            'lokativ' => [$stem . 'i', latinToCyrillic($stem . 'i')],
            'vokativ' => [$stem . 'o', latinToCyrillic($stem . 'o')]
        ]
    ];
}

// Генерация для женского рода на согласный (noć, stvar)
function generateFeminineConsonant($baseWord, $gender, $russianTranslation) {
    $lastChar = mb_substr($baseWord, -1);
    
    // Особые правила для слов на ć, đ, j
    if (in_array($lastChar, ['ć', 'đ', 'j'])) {
        $stem = mb_substr($baseWord, 0, -1) . 'i';
    } else {
        $stem = $baseWord;
    }
    
    return [
        'base_word' => $baseWord,
        'gender' => $gender,
        'russian_translation' => $russianTranslation,
        'cases' => [
            'nominativ' => [$baseWord, latinToCyrillic($baseWord)],
            'genitiv' => [$stem . 'i', latinToCyrillic($stem . 'i')],
            'dativ' => [$stem . 'i', latinToCyrillic($stem . 'i')],
            'akuzativ' => [$baseWord, latinToCyrillic($baseWord)], // Как именительный
            'instrumental' => [$stem . 'u', latinToCyrillic($stem . 'u')],
            'lokativ' => [$stem . 'i', latinToCyrillic($stem . 'i')],
            'vokativ' => [$stem . 'i', latinToCyrillic($stem . 'i')]
        ]
    ];
}

// Генерация для среднего рода на -o, -e (mesto, more)
function generateNeuterOE($baseWord, $gender, $russianTranslation) {
    $stem = mb_substr($baseWord, 0, -1); // Убираем последнюю букву
    
    return [
        'base_word' => $baseWord,
        'gender' => $gender,
        'russian_translation' => $russianTranslation,
        'cases' => [
            'nominativ' => [$baseWord, latinToCyrillic($baseWord)],
            'genitiv' => [$stem . 'a', latinToCyrillic($stem . 'a')],
            'dativ' => [$stem . 'u', latinToCyrillic($stem . 'u')],
            'akuzativ' => [$baseWord, latinToCyrillic($baseWord)], // Как именительный
            'instrumental' => [$stem . 'om', latinToCyrillic($stem . 'om')],
            'lokativ' => [$stem . 'u', latinToCyrillic($stem . 'u')],
            'vokativ' => [$baseWord, latinToCyrillic($baseWord)] // Как именительный
        ]
    ];
}

// Получение основы слова для генерации
function getStem($baseWord, $wordType) {
    switch ($wordType) {
        case 'm_consonant':
            return $baseWord;
        case 'f_a':
            return mb_substr($baseWord, 0, -1);
        default:
            return $baseWord;
    }
}

// Транслитерация латиницы в кириллицу
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

// Список неправильных слов с исключениями
// Список неправильных слов с исключениями
function getIrregularWords() {
    return [
        'momak' => [
            'base_word' => 'momak',
            'gender' => 'm',
            'russian_translation' => 'юноша',
            'cases' => [
                'nominativ' => ['momak', 'момак'],
                'genitiv' => ['momka', 'момка'],
                'dativ' => ['momku', 'момку'],
                'akuzativ' => ['momka', 'момка'],
                'instrumental' => ['momkom', 'момком'],
                'lokativ' => ['momku', 'момку'],
                'vokativ' => ['momče', 'момче'] // Особое звательное!
            ]
        ],
        'čovek' => [
            'base_word' => 'čovek',
            'gender' => 'm',
            'russian_translation' => 'человек',
            'cases' => [
                'nominativ' => ['čovek', 'човек'],
                'genitiv' => ['čoveka', 'човека'],
                'dativ' => ['čoveku', 'човеку'],
                'akuzativ' => ['čoveka', 'човека'],
                'instrumental' => ['čovekom', 'човеком'],
                'lokativ' => ['čoveku', 'човеку'],
                'vokativ' => ['čoveče', 'човече']
            ]
        ],
        'noć' => [
            'base_word' => 'noć',
            'gender' => 'f',
            'russian_translation' => 'ночь',
            'cases' => [
                'nominativ' => ['noć', 'ноћ'],
                'genitiv' => ['noći', 'ноћи'],
                'dativ' => ['noći', 'ноћи'],
                'akuzativ' => ['noć', 'ноћ'],
                'instrumental' => ['noću', 'ноћу'],
                'lokativ' => ['noći', 'ноћи'],
                'vokativ' => ['noći', 'ноћи']
            ]
        ],
        'ime' => [
            'base_word' => 'ime',
            'gender' => 'n',
            'russian_translation' => 'имя',
            'cases' => [
                'nominativ' => ['ime', 'име'],
                'genitiv' => ['imena', 'имена'],
                'dativ' => ['imenu', 'имену'],
                'akuzativ' => ['ime', 'име'],
                'instrumental' => ['imenom', 'именом'],
                'lokativ' => ['imenu', 'имену'],
                'vokativ' => ['ime', 'име']
            ]
        ],
        'dete' => [
            'base_word' => 'dete',
            'gender' => 'n',
            'russian_translation' => 'ребёнок',
            'cases' => [
                'nominativ' => ['dete', 'дете'],
                'genitiv' => ['deteta', 'детета'],
                'dativ' => ['detetu', 'детету'],
                'akuzativ' => ['dete', 'дете'],
                'instrumental' => ['detetom', 'дететом'],
                'lokativ' => ['detetu', 'детету'],
                'vokativ' => ['dete', 'дете']
            ]
        ],
        'sin' => [
            'base_word' => 'sin',
            'gender' => 'm',
            'russian_translation' => 'сын',
            'cases' => [
                'nominativ' => ['sin', 'син'],
                'genitiv' => ['sina', 'сина'],
                'dativ' => ['sinu', 'сину'],
                'akuzativ' => ['sina', 'сина'],
                'instrumental' => ['sinom', 'сином'],
                'lokativ' => ['sinu', 'сину'],
                'vokativ' => ['sine', 'сине']
            ]
        ],
        'brat' => [
            'base_word' => 'brat',
            'gender' => 'm',
            'russian_translation' => 'брат',
            'cases' => [
                'nominativ' => ['brat', 'брат'],
                'genitiv' => ['brata', 'брата'],
                'dativ' => ['bratu', 'брату'],
                'akuzativ' => ['brata', 'брата'],
                'instrumental' => ['bratom', 'братом'],
                'lokativ' => ['bratu', 'брату'],
                'vokativ' => ['brate', 'брате']
            ]
        ]
    ];
}

// Фолбэк для нераспознанных слов
function generateFallback($baseWord, $gender, $russianTranslation) {
    $cyrillic = latinToCyrillic($baseWord);
    
    return [
        'base_word' => $baseWord,
        'gender' => $gender,
        'russian_translation' => $russianTranslation,
        'cases' => [
            'nominativ' => [$baseWord, $cyrillic],
            'genitiv' => [$baseWord . 'a', $cyrillic . 'а'],
            'dativ' => [$baseWord . 'u', $cyrillic . 'у'],
            'akuzativ' => [$baseWord . 'a', $cyrillic . 'а'],
            'instrumental' => [$baseWord . 'om', $cyrillic . 'ом'],
            'lokativ' => [$baseWord . 'u', $cyrillic . 'у'],
            'vokativ' => [$baseWord . 'e', $cyrillic . 'е']
        ]
    ];
}
?>