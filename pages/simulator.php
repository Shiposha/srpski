<!-- Добавьте этот код в конец секции #verbs перед закрывающим </section> -->

<section id="verb-trainer" style="margin-top: 40px; padding: 25px; background-color: #f8f9fa; border-radius: 12px; border: 1px solid #e9ecef;">
    <h3 style="color: #2c3e50; margin-bottom: 25px;">🎯 Тренажер спряжения сербских глаголов (все формы)</h3>
    
    <div id="trainer-container">
        <!-- Статистика -->
        <div id="stats" style="display: flex; justify-content: space-between; margin-bottom: 20px; padding: 15px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div>Правильно: <span id="correct-count">0</span></div>
            <div>Неправильно: <span id="incorrect-count">0</span></div>
            <div>Попыток: <span id="total-count">0</span></div>
            <div>Точность: <span id="accuracy">0%</span></div>
        </div>
     
        <!-- Кнопки управления -->
        <div style="display: flex; gap: 15px; margin-bottom: 25px;">
            <button id="next-verb" style="flex: 1; padding: 15px; background-color: #9b59b6; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 1.1em; font-weight: bold;">
                🔄 Следующий глагол
            </button>
            <button id="reset-stats" style="flex: 1; padding: 15px; background-color: #e74c3c; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 1.1em; font-weight: bold;">
                📊 Сбросить статистику
            </button>
        </div>     

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
            <!-- Информация о глаголе -->
            <div style="padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); position: relative;">
                <p style="margin: 10px 0;">
                    <strong>Глагол:</strong> 
                    <span id="current-verb" style="font-size: 1.4em; color: #e74c3c; font-weight: bold;"></span>
                    <span id="current-verb-cyrillic" style="font-size: 1.4em; color: #3498db; font-weight: bold; margin-left: 10px;"></span>
                </p>
                <p style="margin: 10px 0;">
                    <strong>Перевод:</strong> 
                    <span id="verb-translation" style="font-size: 1.2em; color: #2c3e50;"></span>
                </p>
                <p style="margin: 10px 0;">
                    <strong>Группа:</strong> 
                    <span id="verb-group" style="padding: 4px 8px; background: #3498db; color: white; border-radius: 4px;"></span>
                </p>
                
                <!-- Кнопка воспроизведения аудио -->
                <div style="margin-top: 15px; padding: 10px; background-color: #f8f9fa; border-radius: 6px; border: 1px solid #e9ecef;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <button id="play-verb-audio" 
                                style="padding: 8px 16px; background-color: #9b59b6; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.9em; display: flex; align-items: center; gap: 5px;">
                            🔊 Произношение
                        </button>
                        <div id="audio-status" style="font-size: 0.9em; color: #666;">
                            Нажмите для прослушивания
                        </div>
                        <audio id="verb-audio-player" preload="none"></audio>
                    </div>
                </div>
                
                <p style="margin: 15px 0 0 0; font-size: 0.9em; color: #666;">
                    <em>Заполните все формы спряжения. Можно вводить на латинице или кириллице</em>
                </p>
            </div>
            
            <!-- Настройки тренажера и поиск -->
            <div style="padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <!-- Поиск глагола -->
                <div style="margin-bottom: 15px;">
                    <label for="verb-search" style="display: block; margin-bottom: 8px; font-weight: bold;">
                        🔍 Поиск глагола (латиница/кириллица):
                    </label>
                    <div style="position: relative;">
                        <input type="text" id="verb-search" 
                               placeholder="Введите глагол или начало слова..."
                               style="width: 100%; padding: 10px 40px 10px 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 1em;">
                        <div id="search-clear" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #999; display: none;">
                            ✕
                        </div>
                    </div>
                    <div id="search-results" style="margin-top: 10px; max-height: 200px; overflow-y: auto; display: none; border: 1px solid #e9ecef; border-radius: 6px; background: white;">
                        <!-- Результаты поиска будут добавляться динамически -->
                    </div>
                </div>
                
                <!-- Фильтр по группам -->
                <div>
                    <label for="group-filter" style="display: block; margin-bottom: 8px; font-weight: bold;">Фильтр по группам:</label>
                    <select id="group-filter" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="all">Все группы</option>
                        <option value="A">A-группа (-ati)</option>
                        <option value="I">I-группа (-iti)</option>
                        <option value="E">E-группа (-eti)</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Таблица для ввода всех форм -->
        <div style="margin-bottom: 25px; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h4 style="color: #2c3e50; margin-bottom: 20px;">Заполните все формы спряжения:</h4>
            <table id="conjugation-table" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr style="background-color: #34495e; color: white;">
                        <th style="padding: 12px; text-align: left; width: 20%;">Лицо</th>
                        <th style="padding: 12px; text-align: left; width: 40%;">Спряжение (латиница/кириллица)</th>
                        <th style="padding: 12px; text-align: left; width: 40%;">Результат</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 12px; font-weight: bold;">👤 Ja</td>
                        <td style="padding: 12px;">
                            <input type="text" class="conjugation-input" data-person="ja" 
                                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </td>
                        <td style="padding: 12px;">
                            <div class="result" data-person="ja"></div>
                        </td>
                    </tr>
                    <tr style="background-color: #f8f9fa;">
                        <td style="padding: 12px; font-weight: bold;">👤 Ti</td>
                        <td style="padding: 12px;">
                            <input type="text" class="conjugation-input" data-person="ti" 
                                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </td>
                        <td style="padding: 12px;">
                            <div class="result" data-person="ti"></div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; font-weight: bold;">👤 On/Ona/Ono</td>
                        <td style="padding: 12px;">
                            <input type="text" class="conjugation-input" data-person="on" 
                                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </td>
                        <td style="padding: 12px;">
                            <div class="result" data-person="on"></div>
                        </td>
                    </tr>
                    <tr style="background-color: #f8f9fa;">
                        <td style="padding: 12px; font-weight: bold;">👥 Mi</td>
                        <td style="padding: 12px;">
                            <input type="text" class="conjugation-input" data-person="mi" 
                                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </td>
                        <td style="padding: 12px;">
                            <div class="result" data-person="mi"></div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; font-weight: bold;">👥 Vi</td>
                        <td style="padding: 12px;">
                            <input type="text" class="conjugation-input" data-person="vi" 
                                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </td>
                        <td style="padding: 12px;">
                            <div class="result" data-person="vi"></div>
                        </td>
                    </tr>
                    <tr style="background-color: #f8f9fa;">
                        <td style="padding: 12px; font-weight: bold;">👥 Oni/One/Ona</td>
                        <td style="padding: 12px;">
                            <input type="text" class="conjugation-input" data-person="oni" 
                                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </td>
                        <td style="padding: 12px;">
                            <div class="result" data-person="oni"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <!-- Кнопки проверки -->
            <div style="display: flex; gap: 15px;">
                <button id="check-all" style="flex: 1; padding: 15px; background-color: #2ecc71; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 1.1em; font-weight: bold;">
                    ✅ Проверить все формы
                </button>
                <button id="show-answers" style="flex: 1; padding: 15px; background-color: #3498db; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 1.1em; font-weight: bold;">
                    📋 Показать ответы
                </button>
                <button id="clear-all" style="flex: 1; padding: 15px; background-color: #95a5a6; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 1.1em; font-weight: bold;">
                    🗑️ Очистить все
                </button>
            </div>
        </div>
        
        <!-- Общий результат -->
        <div id="overall-result" style="margin-bottom: 25px; min-height: 60px; padding: 20px; border-radius: 8px;"></div>
    </div>
</section>

<script>

// База глаголов с формами на латинице
const verbs = [
    // A-группа (-ati) - добавленные глаголы
    { infinitive: "znati", translation: "знать; уметь", group: "A", conjugations: { ja: "znam", ti: "znaš", on: "zna", mi: "znamo", vi: "znate", oni: "znaju" } },
    { infinitive: "odgovarati", translation: "отвечать", group: "A", conjugations: { ja: "odgovaram", ti: "odgovaraš", on: "odgovara", mi: "odgovaramo", vi: "odgovarate", oni: "odgovaraju" } },
    { infinitive: "pitati", translation: "спрашивать", group: "A", conjugations: { ja: "pitam", ti: "pitaš", on: "pita", mi: "pitamo", vi: "pitate", oni: "pitaju" } },
    { infinitive: "pevati", translation: "петь", group: "A", conjugations: { ja: "pevam", ti: "pevaš", on: "peva", mi: "pevamo", vi: "pevate", oni: "pevaju" } },
    { infinitive: "razgovarati", translation: "разговаривать", group: "A", conjugations: { ja: "razgovaram", ti: "razgovaraš", on: "razgovara", mi: "razgovaramo", vi: "razgovarate", oni: "razgovaraju" } },
    { infinitive: "gurati", translation: "толкать", group: "A", conjugations: { ja: "guram", ti: "guraš", on: "gura", mi: "guramo", vi: "gurate", oni: "guraju" } },
    { infinitive: "plivati", translation: "плавать", group: "A", conjugations: { ja: "plivam", ti: "plivaš", on: "pliva", mi: "plivamo", vi: "plivate", oni: "plivaju" } },
    { infinitive: "štampati", translation: "печатать", group: "A", conjugations: { ja: "štampam", ti: "štampaš", on: "štampa", mi: "štampamo", vi: "štampate", oni: "štampaju" } },
    { infinitive: "kucati", translation: "стучать", group: "A", conjugations: { ja: "kucam", ti: "kucaš", on: "kuca", mi: "kucamo", vi: "kucate", oni: "kucaju" } },
    { infinitive: "gledati", translation: "смотреть", group: "A", conjugations: { ja: "gledam", ti: "gledaš", on: "gleda", mi: "gledamo", vi: "gledate", oni: "gledaju" } },
    { infinitive: "čuvati", translation: "беречь; оберегать", group: "A", conjugations: { ja: "čuvam", ti: "čuvaš", on: "čuva", mi: "čuvamo", vi: "čuvate", oni: "čuvaju" } },
    { infinitive: "uspevati", translation: "удаваться, получаться", group: "A", conjugations: { ja: "uspevam", ti: "uspevaš", on: "uspeva", mi: "uspevamo", vi: "uspevate", oni: "uspevaju" } },
    { infinitive: "sklanjati", translation: "убирать; прятать", group: "A", conjugations: { ja: "sklanjam", ti: "sklanjaš", on: "sklanja", mi: "sklanjamo", vi: "sklanjate", oni: "sklanjaju" } },
    { infinitive: "postavljati", translation: "ставить; расставлять", group: "A", conjugations: { ja: "postavljam", ti: "postavljaš", on: "postavlja", mi: "postavljamo", vi: "postavljate", oni: "postavljaju" } },
    { infinitive: "sipati", translation: "наливать; насыпать", group: "A", conjugations: { ja: "sipam", ti: "sipaš", on: "sipa", mi: "sipamo", vi: "sipate", oni: "sipaju" } },
    { infinitive: "kuvati", translation: "варить, готовить", group: "A", conjugations: { ja: "kuvam", ti: "kuvaš", on: "kuva", mi: "kuvamo", vi: "kuvate", oni: "kuvaju" } },
    { infinitive: "spremati", translation: "готовить, подготавливать", group: "A", conjugations: { ja: "spremam", ti: "spremaš", on: "sprema", mi: "spremamo", vi: "spremate", oni: "spremaju" } },
    { infinitive: "čitati", translation: "читать", group: "A", conjugations: { ja: "čitam", ti: "čitaš", on: "čita", mi: "čitamo", vi: "čitate", oni: "čitaju" } },
    { infinitive: "plaćati", translation: "платить", group: "A", conjugations: { ja: "plaćam", ti: "plaćaš", on: "plaća", mi: "plaćamo", vi: "plaćate", oni: "plaćaju" } },
    { infinitive: "smatrati", translation: "считать, полагать", group: "A", conjugations: { ja: "smatram", ti: "smatraš", on: "smatra", mi: "smatramo", vi: "smatrate", oni: "smatraju" } },
    { infinitive: "spavati", translation: "спать", group: "A", conjugations: { ja: "spavam", ti: "spavaš", on: "spava", mi: "spavamo", vi: "spavate", oni: "spavaju" } },
    { infinitive: "ručati", translation: "обедать", group: "A", conjugations: { ja: "ručam", ti: "ručaš", on: "ruča", mi: "ručamo", vi: "ručate", oni: "ručaju" } },
    { infinitive: "večerati", translation: "ужинать", group: "A", conjugations: { ja: "večeram", ti: "večeraš", on: "večera", mi: "večeramo", vi: "večerate", oni: "večeraju" } },
    { infinitive: "ponavljati", translation: "повторять", group: "A", conjugations: { ja: "ponavljam", ti: "ponavljaš", on: "ponavlja", mi: "ponavljamo", vi: "ponavljate", oni: "ponavljaju" } },
    { infinitive: "otvarati", translation: "открывать", group: "A", conjugations: { ja: "otvaram", ti: "otvaraš", on: "otvara", mi: "otvaramo", vi: "otvarate", oni: "otvaraju" } },
    { infinitive: "zatvarati", translation: "закрывать", group: "A", conjugations: { ja: "zatvaram", ti: "zatvaraš", on: "zatvara", mi: "zatvaramo", vi: "zatvarate", oni: "zatvaraju" } },
    { infinitive: "čekati", translation: "ждать", group: "A", conjugations: { ja: "čekam", ti: "čekaš", on: "čeka", mi: "čekamo", vi: "čekate", oni: "čekaju" } },
    { infinitive: "slikati", translation: "фотографировать; рисовать", group: "A", conjugations: { ja: "slikam", ti: "slikaš", on: "slika", mi: "slikamo", vi: "slikate", oni: "slikaju" } },
    { infinitive: "imati", translation: "иметь", group: "A", conjugations: { ja: "imam", ti: "imaš", on: "ima", mi: "imamo", vi: "imate", oni: "imaju" } },
    { infinitive: "nemati", translation: "не иметь", group: "A", conjugations: { ja: "nemam", ti: "nemaš", on: "nema", mi: "nemamo", vi: "nemate", oni: "nemaju" } },
    { infinitive: "aplicirati", translation: "подавать заявку", group: "A", conjugations: { ja: "apliciram", ti: "apliciraš", on: "aplicira", mi: "apliciramo", vi: "aplicirate", oni: "apliciraju" } },
    { infinitive: "bacati", translation: "бросать", group: "A", conjugations: { ja: "bacam", ti: "bacaš", on: "baca", mi: "bacamo", vi: "bacate", oni: "bacaju" } },
    { infinitive: "računati", translation: "считать; рассчитывать", group: "A", conjugations: { ja: "računam", ti: "računaš", on: "računa", mi: "računamo", vi: "računate", oni: "računaju" } },
    { infinitive: "uzimati", translation: "брать", group: "A", conjugations: { ja: "uzimam", ti: "uzimaš", on: "uzima", mi: "uzimamo", vi: "uzimate", oni: "uzimaju" } },
    { infinitive: "birati", translation: "выбирать", group: "A", conjugations: { ja: "biram", ti: "biraš", on: "bira", mi: "biramo", vi: "birate", oni: "biraju" } },
    { infinitive: "pokušavati", translation: "пытаться; пробовать", group: "A", conjugations: { ja: "pokušavam", ti: "pokušavaš", on: "pokušava", mi: "pokušavamo", vi: "pokušavate", oni: "pokušavaju" } },
    { infinitive: "probati", translation: "пробовать; примерять", group: "A", conjugations: { ja: "probam", ti: "probaš", on: "proba", mi: "probamo", vi: "probate", oni: "probaju" } },
    { infinitive: "čestitati", translation: "поздравлять", group: "A", conjugations: { ja: "čestitam", ti: "čestitaš", on: "čestita", mi: "čestitamo", vi: "čestitate", oni: "čestitaju" } },
    { infinitive: "fenirati se", translation: "укладывать волосы феном", group: "A", conjugations: { ja: "feniram se", ti: "feniraš se", on: "fenira se", mi: "feniramo se", vi: "fenirate se", oni: "feniraju se" } },
    { infinitive: "šetati se", translation: "гулять, прогуливаться", group: "A", conjugations: { ja: "šetam se", ti: "šetaš se", on: "šeta se", mi: "šetamo se", vi: "šetate se", oni: "šetaju se" } },
    { infinitive: "skidati se", translation: "раздеваться", group: "A", conjugations: { ja: "skidam se", ti: "skidaš se", on: "skida se", mi: "skidamo se", vi: "skidate se", oni: "skidaju se" } },
    { infinitive: "umivati se", translation: "умываться", group: "A", conjugations: { ja: "umivam se", ti: "umivaš se", on: "umiva se", mi: "umivamo se", vi: "umivate se", oni: "umivaju se" } },
    { infinitive: "tuširati se", translation: "принимать душ", group: "A", conjugations: { ja: "tuširam se", ti: "tuširaš se", on: "tušira se", mi: "tuširamo se", vi: "tuširate se", oni: "tuširaju se" } },
    { infinitive: "kupati se", translation: "купаться", group: "A", conjugations: { ja: "kupam se", ti: "kupaš se", on: "kupa se", mi: "kupamo se", vi: "kupate se", oni: "kupaju se" } },
    { infinitive: "svađati se", translation: "ссориться, ругаться", group: "A", conjugations: { ja: "svađam se", ti: "svađaš se", on: "svađa se", mi: "svađamo se", vi: "svađate se", oni: "svađaju se" } },
    

    // Глаголы группы I
    { infinitive: "ležati", translation: "лежать", group: "I", conjugations: { ja: "ležim", ti: "ležiš", on: "leži", mi: "ležimo", vi: "ležite", oni: "leže" } },
    { infinitive: "ćutati", translation: "молчать", group: "I", conjugations: { ja: "ćutim", ti: "ćutiš", on: "ćuti", mi: "ćutimo", vi: "ćutite", oni: "ćute" } },
    { infinitive: "držati", translation: "держать", group: "I", conjugations: { ja: "držim", ti: "držiš", on: "drži", mi: "držimo", vi: "držite", oni: "drže" } },
    { infinitive: "postojati", translation: "существовать", group: "I", conjugations: { ja: "postojim", ti: "postojiš", on: "postoji", mi: "postojimo", vi: "postojite", oni: "postoje" } },
    { infinitive: "trčati", translation: "бегать", group: "I", conjugations: { ja: "trčim", ti: "trčiš", on: "trči", mi: "trčimo", vi: "trčite", oni: "trče" } },
    { infinitive: "bežati", translation: "убегать", group: "I", conjugations: { ja: "bežim", ti: "bežiš", on: "beži", mi: "bežimo", vi: "bežite", oni: "beže" } },
    { infinitive: "stajati", translation: "стоять", group: "I", conjugations: { ja: "stojim", ti: "stojiš", on: "stoji", mi: "stojimo", vi: "stojite", oni: "stoje" } },
    { infinitive: "brojati", translation: "считать, пересчитывать", group: "I", conjugations: { ja: "brojim", ti: "brojiš", on: "broji", mi: "brojimo", vi: "brojite", oni: "broje" } },
    { infinitive: "bojati se", translation: "бояться, страшиться", group: "I", conjugations: { ja: "bojim se", ti: "bojiš se", on: "boji se", mi: "bojimo se", vi: "bojite se", oni: "boje se" } },
    { infinitive: "voleti", translation: "любить", group: "I", conjugations: { ja: "volim", ti: "voliš", on: "voli", mi: "volimo", vi: "volite", oni: "vole" } },
    { infinitive: "sedeti", translation: "сидеть", group: "I", conjugations: { ja: "sedim", ti: "sediš", on: "sedi", mi: "sedimo", vi: "sedite", oni: "sede" } },
    { infinitive: "živeti", translation: "жить", group: "I", conjugations: { ja: "živim", ti: "živiš", on: "živi", mi: "živimo", vi: "živite", oni: "žive" } },
    { infinitive: "videti", translation: "видеть", group: "I", conjugations: { ja: "vidim", ti: "vidiš", on: "vidi", mi: "vidimo", vi: "vidite", oni: "vide" } },
    { infinitive: "mrzeti", translation: "ненавидеть", group: "I", conjugations: { ja: "mrzim", ti: "mrziš", on: "mrzi", mi: "mrzimo", vi: "mrzite", oni: "mrze" } },
    { infinitive: "štedeti", translation: "экономить, сберегать", group: "I", conjugations: { ja: "štedim", ti: "štediš", on: "štedi", mi: "štedimo", vi: "štedite", oni: "štede" } },
    { infinitive: "želeti", translation: "хотеть; желать", group: "I", conjugations: { ja: "želim", ti: "želiš", on: "želi", mi: "želimo", vi: "želite", oni: "žele" } },
    { infinitive: "lepiti", translation: "лепить, клеить", group: "I", conjugations: { ja: "lepim", ti: "lepiš", on: "lepi", mi: "lepimo", vi: "lepite", oni: "lepe" } },
    { infinitive: "pržiti", translation: "жарить, поджаривать", group: "I", conjugations: { ja: "pržim", ti: "pržiš", on: "prži", mi: "pržimo", vi: "pržite", oni: "prže" } },
    { infinitive: "praviti", translation: "делать, создавать", group: "I", conjugations: { ja: "pravim", ti: "praviš", on: "pravi", mi: "pravimo", vi: "pravite", oni: "prave" } },
    { infinitive: "cediti", translation: "выжимать; отцеживать", group: "I", conjugations: { ja: "cedim", ti: "cediš", on: "cedi", mi: "cedimo", vi: "cedite", oni: "cede" } },
    { infinitive: "tražiti", translation: "искать; требовать; просить", group: "I", conjugations: { ja: "tražim", ti: "tražiš", on: "traži", mi: "tražimo", vi: "tražite", oni: "traže" } },
    { infinitive: "voziti", translation: "водить; везти", group: "I", conjugations: { ja: "vozim", ti: "voziš", on: "vozi", mi: "vozimo", vi: "vozite", oni: "voze" } },
    { infinitive: "paziti", translation: "внимательно смотреть", group: "I", conjugations: { ja: "pazim", ti: "paziš", on: "pazi", mi: "pazimo", vi: "pazite", oni: "paze" } },
    { infinitive: "maziti", translation: "угождать; баловать", group: "I", conjugations: { ja: "mazim", ti: "maziš", on: "mazi", mi: "mazimo", vi: "mazite", oni: "maze" } },
    { infinitive: "vaditi", translation: "вынимать", group: "I", conjugations: { ja: "vadim", ti: "vadiš", on: "vadi", mi: "vadimo", vi: "vadite", oni: "vade" } },
    { infinitive: "dolaziti", translation: "приходить; приезжать", group: "I", conjugations: { ja: "dolazim", ti: "dolaziš", on: "dolazi", mi: "dolazimo", vi: "dolazite", oni: "dolaze" } },
    { infinitive: "puniti", translation: "заряжать", group: "I", conjugations: { ja: "punim", ti: "puniš", on: "puni", mi: "punimo", vi: "punite", oni: "pune" } },
    { infinitive: "misliti", translation: "думать", group: "I", conjugations: { ja: "mislim", ti: "misliš", on: "misli", mi: "mislimo", vi: "mislite", oni: "misle" } },
    { infinitive: "čistiti", translation: "чистить; очищать", group: "I", conjugations: { ja: "čistim", ti: "čistiš", on: "čisti", mi: "čistimo", vi: "čistite", oni: "čiste" } },
    { infinitive: "raditi", translation: "работать; делать", group: "I", conjugations: { ja: "radim", ti: "radiš", on: "radi", mi: "radimo", vi: "radite", oni: "rade" } },
    { infinitive: "koristiti", translation: "использовать", group: "I", conjugations: { ja: "koristim", ti: "koristiš", on: "koristi", mi: "koristimo", vi: "koristite", oni: "koriste" } },
    { infinitive: "donositi", translation: "приносить; доставлять", group: "I", conjugations: { ja: "donosim", ti: "donosiš", on: "donosi", mi: "donosimo", vi: "donosite", oni: "donose" } },
    { infinitive: "pratiti", translation: "следовать (за кем-либо)", group: "I", conjugations: { ja: "pratim", ti: "pratiš", on: "prati", mi: "pratimo", vi: "pratite", oni: "prate" } },
    { infinitive: "ulaziti", translation: "входить", group: "I", conjugations: { ja: "ulazim", ti: "ulaziš", on: "ulazi", mi: "ulazimo", vi: "ulazite", oni: "ulaze" } },
    { infinitive: "izlaziti", translation: "выходить", group: "I", conjugations: { ja: "izlazim", ti: "izlaziš", on: "izlazi", mi: "izlazimo", vi: "izlazite", oni: "izlaze" } },
    { infinitive: "nuditi", translation: "предлагать; угощать", group: "I", conjugations: { ja: "nudim", ti: "nudiš", on: "nudi", mi: "nudimo", vi: "nudite", oni: "nude" } },
    { infinitive: "ljubiti", translation: "целовать", group: "I", conjugations: { ja: "ljubim", ti: "ljubiš", on: "ljubi", mi: "ljubimo", vi: "ljubite", oni: "ljube" } },
    { infinitive: "braniti", translation: "защищать", group: "I", conjugations: { ja: "branim", ti: "braniš", on: "brani", mi: "branimo", vi: "branite", oni: "brane" } },
    { infinitive: "pušiti", translation: "курить", group: "I", conjugations: { ja: "pušim", ti: "pušiš", on: "puši", mi: "pušimo", vi: "pušite", oni: "puše" } },
    { infinitive: "baviti se", translation: "заниматься", group: "I", conjugations: { ja: "bavim se", ti: "baviš se", on: "bavi se", mi: "bavimo se", vi: "bavite se", oni: "bave se" } },
    { infinitive: "družiti se", translation: "общаться", group: "I", conjugations: { ja: "družim se", ti: "družiš se", on: "druži se", mi: "družimo se", vi: "družite se", oni: "druže se" } },
    { infinitive: "šaliti se", translation: "шутить", group: "I", conjugations: { ja: "šalim se", ti: "šališ se", on: "šali se", mi: "šalimo se", vi: "šalite se", oni: "šale se" } },
    { infinitive: "seliti se", translation: "выселяться; переезжать", group: "I", conjugations: { ja: "selim se", ti: "seliš se", on: "seli se", mi: "selimo se", vi: "selite se", oni: "sele se" } },
    { infinitive: "truditi se", translation: "стараться", group: "I", conjugations: { ja: "tružim se", ti: "tružiš se", on: "truži se", mi: "tružimo se", vi: "tružite se", oni: "truže se" } },
    { infinitive: "snalaziti se", translation: "ориентироваться; приспосабливаться", group: "I", conjugations: { ja: "snalazim se", ti: "snalaziš se", on: "snalazi se", mi: "snalazimo se", vi: "snalazite se", oni: "snalaze se" } },
    

    // Глаголы группы E
    { infinitive: "zvati", translation: "звать; звонить; приглашать", group: "E", conjugations: { ja: "zovem", ti: "zoveš", on: "zove", mi: "zovemo", vi: "zovete", oni: "zovu" } },
    { infinitive: "prati", translation: "мыть", group: "E", conjugations: { ja: "perem", ti: "pereš", on: "pere", mi: "peremo", vi: "perete", oni: "peru" } },
    { infinitive: "slati", translation: "посылать; отправлять", group: "E", conjugations: { ja: "šaljem", ti: "šalješ", on: "šalje", mi: "šaljemo", vi: "šaljete", oni: "šalju" } },
    { infinitive: "piti", translation: "пить", group: "E", conjugations: { ja: "pijem", ti: "piješ", on: "pije", mi: "pijemo", vi: "pijete", oni: "piju" } },
    { infinitive: "kriti", translation: "скрывать; прятать", group: "E", conjugations: { ja: "krijem", ti: "kriješ", on: "krije", mi: "krijemo", vi: "krijete", oni: "kriju" } },
    { infinitive: "ostajati", translation: "оставаться", group: "E", conjugations: { ja: "ostajem", ti: "ostaješ", on: "ostaje", mi: "ostajemo", vi: "ostajete", oni: "ostaju" } },
    { infinitive: "počinjati", translation: "начинать; начинаться", group: "E", conjugations: { ja: "počinjem", ti: "počinješ", on: "počinje", mi: "počinjemo", vi: "počinjete", oni: "počinju" } },
    { infinitive: "kašljati", translation: "кашлять", group: "E", conjugations: { ja: "kašljem", ti: "kašlješ", on: "kašlje", mi: "kašljemo", vi: "kašljete", oni: "kašlju" } },
    { infinitive: "lagati", translation: "врать; обманывать", group: "E", conjugations: { ja: "lažem", ti: "lažeš", on: "laže", mi: "lažemo", vi: "lažete", oni: "lažu" } },
    { infinitive: "polagati", translation: "сдавать (экзамен)", group: "E", conjugations: { ja: "polažem", ti: "polažeš", on: "polaže", mi: "polažemo", vi: "polažete", oni: "polažu" } },
    { infinitive: "predlagati", translation: "предлагать", group: "E", conjugations: { ja: "predlažem", ti: "predlažeš", on: "predlaže", mi: "predlažemo", vi: "predlažete", oni: "predlažu" } },
    { infinitive: "pomagati", translation: "помогать", group: "E", conjugations: { ja: "pomažem", ti: "pomažeš", on: "pomaže", mi: "pomažemo", vi: "pomažete", oni: "pomažu" } },
    { infinitive: "stizati", translation: "догонять; прибывать", group: "E", conjugations: { ja: "stižem", ti: "stižeš", on: "stiže", mi: "stižemo", vi: "stižete", oni: "stižu" } },
    { infinitive: "dizati", translation: "поднимать", group: "E", conjugations: { ja: "dižem", ti: "dižeš", on: "diže", mi: "dižemo", vi: "dižete", oni: "dižu" } },
    { infinitive: "mazati", translation: "мазать", group: "E", conjugations: { ja: "mažem", ti: "mažeš", on: "maže", mi: "mažemo", vi: "mažete", oni: "mažu" } },
    { infinitive: "naručivati", translation: "заказывать", group: "E", conjugations: { ja: "naručujem", ti: "naručuješ", on: "naručuje", mi: "naručujemo", vi: "naručujete", oni: "naručuju" } },
    { infinitive: "sređivati", translation: "приводить в порядок", group: "E", conjugations: { ja: "sređujem", ti: "sređuješ", on: "sređuje", mi: "sređujemo", vi: "sređujete", oni: "sređuju" } },
    { infinitive: "istraživati", translation: "исследовать", group: "E", conjugations: { ja: "istražujem", ti: "istražuješ", on: "istražuje", mi: "istražujemo", vi: "istražujete", oni: "istražuju" } },
    { infinitive: "davati", translation: "давать", group: "E", conjugations: { ja: "dajem", ti: "daješ", on: "daje", mi: "dajemo", vi: "dajete", oni: "daju" } },
    { infinitive: "dodavati", translation: "прибавлять; подавать", group: "E", conjugations: { ja: "dodajem", ti: "dodaješ", on: "dodaje", mi: "dodajemo", vi: "dodajete", oni: "dodaju" } },
    { infinitive: "prodavati", translation: "продавать", group: "E", conjugations: { ja: "prodajem", ti: "prodaješ", on: "prodaje", mi: "prodajemo", vi: "prodajete", oni: "prodaju" } },
    { infinitive: "pakovati", translation: "упаковывать", group: "E", conjugations: { ja: "pakujem", ti: "pakuješ", on: "pakuje", mi: "pakujemo", vi: "pakujete", oni: "pakuju" } },
    { infinitive: "verovati", translation: "верить", group: "E", conjugations: { ja: "verujem", ti: "veruješ", on: "veruje", mi: "verujemo", vi: "verujete", oni: "veruju" } },
    { infinitive: "letovati", translation: "проводить лето", group: "E", conjugations: { ja: "letujem", ti: "letuješ", on: "letuje", mi: "letujemo", vi: "letujete", oni: "letuju" } },
    { infinitive: "kupovati", translation: "покупать", group: "E", conjugations: { ja: "kupujem", ti: "kupuješ", on: "kupuje", mi: "kupujemo", vi: "kupujete", oni: "kupuju" } },
    { infinitive: "putovati", translation: "путешествовать; ездить", group: "E", conjugations: { ja: "putujem", ti: "putuješ", on: "putuje", mi: "putujemo", vi: "putujete", oni: "putuju" } },
    { infinitive: "napredovati", translation: "прогрессировать", group: "E", conjugations: { ja: "napredujem", ti: "napreduješ", on: "napreduje", mi: "napredujemo", vi: "napredujete", oni: "napreduju" } },
    { infinitive: "doručkovati", translation: "завтракать", group: "E", conjugations: { ja: "doručkujem", ti: "doručkuješ", on: "doručkuje", mi: "doručkujemo", vi: "doručkujete", oni: "doručkuju" } },
    { infinitive: "iznajmljivati", translation: "сдавать в аренду; брать в аренду", group: "E", conjugations: { ja: "iznajmljujem", ti: "iznajmljuješ", on: "iznajmljuje", mi: "iznajmljujemo", vi: "iznajmljujete", oni: "iznajmljuju" } },
    { infinitive: "prijavljivati se", translation: "подавать заявление", group: "E", conjugations: { ja: "prijavljujem se", ti: "prijavljuješ se", on: "prijavljuje se", mi: "prijavljujemo se", vi: "prijavljujete se", oni: "prijavljuju se" } },
    { infinitive: "jesti", translation: "есть", group: "E", conjugations: { ja: "jedem", ti: "jedeš", on: "jede", mi: "jedemo", vi: "jedete", oni: "jedu" } },
    { infinitive: "ići", translation: "идти", group: "E", conjugations: { ja: "idem", ti: "ideš", on: "ide", mi: "idemo", vi: "idete", oni: "idu" } },
    { infinitive: "seći", translation: "резать", group: "E", conjugations: { ja: "sečem", ti: "sečeš", on: "seče", mi: "sečemo", vi: "sečete", oni: "seku" } },
    { infinitive: "peći", translation: "печь", group: "E", conjugations: { ja: "pečem", ti: "pečeš", on: "peče", mi: "pečemo", vi: "pečete", oni: "peku" } },
    { infinitive: "vući", translation: "тянуть", group: "E", conjugations: { ja: "vučem", ti: "vučeš", on: "vuče", mi: "vučemo", vi: "vučete", oni: "vuku" } },
    { infinitive: "tući", translation: "бить", group: "E", conjugations: { ja: "tučem", ti: "tučeš", on: "tuče", mi: "tučemo", vi: "tučete", oni: "tuku" } },
    { infinitive: "vikati", translation: "кричать", group: "E", conjugations: { ja: "vičem", ti: "vičeš", on: "viče", mi: "vičemo", vi: "vičete", oni: "viču" } },
    { infinitive: "rezervisati", translation: "бронировать", group: "E", conjugations: { ja: "rezervišem", ti: "rezervišeš", on: "rezerviše", mi: "rezervišemo", vi: "rezervišete", oni: "rezervišu" } },
    { infinitive: "brisati", translation: "вытирать; стирать", group: "E", conjugations: { ja: "brišem", ti: "brišeš", on: "briše", mi: "brišemo", vi: "brišete", oni: "brišu" } },
    { infinitive: "pisati", translation: "писать", group: "E", conjugations: { ja: "pišem", ti: "pišeš", on: "piše", mi: "pišemo", vi: "pišete", oni: "pišu" } },
    { infinitive: "skretati", translation: "сворачивать", group: "E", conjugations: { ja: "skrećem", ti: "skrećeš", on: "skreće", mi: "skrećemo", vi: "skrećete", oni: "skreću" } },
    { infinitive: "okretati se", translation: "разворачиваться", group: "E", conjugations: { ja: "okrećem se", ti: "okrećeš se", on: "okreće se", mi: "okrećemo se", vi: "okrećete se", oni: "okreću se" } },
    { infinitive: "brijati", translation: "брить", group: "E", conjugations: { ja: "brijem", ti: "briješ", on: "brije", mi: "brijemo", vi: "brijete", oni: "briju" } },
    { infinitive: "dobiti", translation: "получать", group: "E", conjugations: { ja: "dobijem", ti: "dobiješ", on: "dobije", mi: "dobijemo", vi: "dobijete", oni: "dobiju" } },
    { infinitive: "brinuti", translation: "беспокоиться", group: "E", conjugations: { ja: "brinem", ti: "brineš", on: "brine", mi: "brinemo", vi: "brinete", oni: "brinu" } },

    // Дополнительные глаголы для базы

    // A-группа (-ati)
    { infinitive: "učiti", translation: "учить, изучать", group: "A", conjugations: { ja: "učim", ti: "učiš", on: "uči", mi: "učimo", vi: "učite", oni: "uče" } },
    { infinitive: "slušati", translation: "слушать", group: "A", conjugations: { ja: "slušam", ti: "slušaš", on: "sluša", mi: "slušamo", vi: "slušate", oni: "slušaju" } },
    { infinitive: "igrati", translation: "играть", group: "A", conjugations: { ja: "igram", ti: "igraš", on: "igra", mi: "igramo", vi: "igrate", oni: "igraju" } },
    { infinitive: "plakati", translation: "плакать", group: "A", conjugations: { ja: "plačem", ti: "plačeš", on: "plače", mi: "plačemo", vi: "plačete", oni: "plaču" } },
    { infinitive: "smijati se", translation: "смеяться", group: "A", conjugations: { ja: "smijem se", ti: "smiješ se", on: "smije se", mi: "smijemo se", vi: "smijete se", oni: "smiju se" } },
    { infinitive: "dići", translation: "поднимать", group: "A", conjugations: { ja: "dižem", ti: "dižeš", on: "diže", mi: "dižemo", vi: "dižete", oni: "dižu" } },

    // I-группа (-iti)
    { infinitive: "ljutiti se", translation: "сердиться", group: "I", conjugations: { ja: "ljutim se", ti: "ljutiš se", on: "ljuti se", mi: "ljutimo se", vi: "ljutite se", oni: "ljute se" } },
    { infinitive: "razumjeti", translation: "понимать", group: "I", conjugations: { ja: "razumijem", ti: "razumiješ", on: "razumije", mi: "razumijemo", vi: "razumijete", oni: "razumiju" } },
    { infinitive: "zaboraviti", translation: "забывать", group: "I", conjugations: { ja: "zaboravim", ti: "zaboraviš", on: "zaboravi", mi: "zaboravimo", vi: "zaboravite", oni: "zaborave" } },
    { infinitive: "pamtiti", translation: "помнить", group: "I", conjugations: { ja: "pamtim", ti: "pamtiš", on: "pamti", mi: "pamtimo", vi: "pamtite", oni: "pamte" } },
    { infinitive: "osjećati", translation: "чувствовать", group: "I", conjugations: { ja: "osjećam", ti: "osjećaš", on: "osjeća", mi: "osjećamo", vi: "osjećate", oni: "osjećaju" } },

    // E-группа (-eti)
    { infinitive: "moći", translation: "мочь, уметь", group: "E", conjugations: { ja: "mogu", ti: "možeš", on: "može", mi: "možemo", vi: "možete", oni: "mogu" } },
    { infinitive: "htjeti", translation: "хотеть", group: "E", conjugations: { ja: "hoću", ti: "hoćeš", on: "hoće", mi: "hoćemo", vi: "hoćete", oni: "hoće" } },
    { infinitive: "trebati", translation: "нужно, требоваться", group: "E", conjugations: { ja: "trebam", ti: "trebaš", on: "treba", mi: "trebamo", vi: "trebate", oni: "trebaju" } },
    { infinitive: "vrijediti", translation: "стоить", group: "E", conjugations: { ja: "vrijedim", ti: "vrijediš", on: "vrijedi", mi: "vrijedimo", vi: "vrijedite", oni: "vrijede" } },

    // Глаголы движения
    { infinitive: "doći", translation: "прийти", group: "E", conjugations: { ja: "dođem", ti: "dođeš", on: "dođe", mi: "dođemo", vi: "dođete", oni: "dođu" } },
    { infinitive: "izaći", translation: "выйти", group: "E", conjugations: { ja: "izađem", ti: "izađeš", on: "izađe", mi: "izađemo", vi: "izađete", oni: "izađu" } },
    { infinitive: "proći", translation: "пройти", group: "E", conjugations: { ja: "prođem", ti: "prođeš", on: "prođe", mi: "prođemo", vi: "prođete", oni: "prođu" } },

    // Бытовые глаголы
    { infinitive: "otići", translation: "уйти", group: "E", conjugations: { ja: "otićem", ti: "otićeš", on: "otiće", mi: "otićemo", vi: "otićete", oni: "otiću" } },
    { infinitive: "naći", translation: "найти", group: "E", conjugations: { ja: "nađem", ti: "nađeš", on: "nađe", mi: "nađemo", vi: "nađete", oni: "nađu" } },
    { infinitive: "reći", translation: "сказать", group: "E", conjugations: { ja: "kažem", ti: "kažeš", on: "kaže", mi: "kažemo", vi: "kažete", oni: "kažu" } },

    // Профессиональные/учебные
    { infinitive: "predavati", translation: "преподавать", group: "A", conjugations: { ja: "predajem", ti: "predaješ", on: "predaje", mi: "predajemo", vi: "predajete", oni: "predaju" } },
    { infinitive: "učiti", translation: "учить", group: "I", conjugations: { ja: "učim", ti: "učiš", on: "uči", mi: "učimo", vi: "učite", oni: "uče" } },
    { infinitive: "studirati", translation: "учиться в вузе", group: "A", conjugations: { ja: "studiram", ti: "studiraš", on: "studira", mi: "studiramo", vi: "studirate", oni: "studiraju" } },

    // Эмоции и состояния
    { infinitive: "voljeti", translation: "любить", group: "I", conjugations: { ja: "volim", ti: "voliš", on: "voli", mi: "volimo", vi: "volite", oni: "vole" } },
    { infinitive: "sretati", translation: "встречать", group: "A", conjugations: { ja: "srećem", ti: "srećeš", on: "sreće", mi: "srećemo", vi: "srećete", oni: "sreću" } },
    { infinitive: "žaliti", translation: "жалеть", group: "I", conjugations: { ja: "žalim", ti: "žališ", on: "žali", mi: "žalimo", vi: "žalite", oni: "žale" } },

    // Время и планирование
    { infinitive: "planirati", translation: "планировать", group: "A", conjugations: { ja: "planiram", ti: "planiraš", on: "planira", mi: "planiramo", vi: "planirate", oni: "planiraju" } },
    { infinitive: "završiti", translation: "заканчивать", group: "I", conjugations: { ja: "završim", ti: "završiš", on: "završi", mi: "završimo", vi: "završite", oni: "završe" } },
    { infinitive: "početi", translation: "начинать", group: "E", conjugations: { ja: "počnem", ti: "počneš", on: "počne", mi: "počnemo", vi: "počnete", oni: "počnu" } }
];

let currentVerb = null;
let stats = {
    correct: 0,
    incorrect: 0,
    total: 0
};

// Функции для конвертации между латиницей и кириллицей
const latinToCyrillicMap = {
    'a': 'а', 'b': 'б', 'c': 'ц', 'č': 'ч', 'ć': 'ћ', 'd': 'д', 'đ': 'ђ',
    'e': 'е', 'f': 'ф', 'g': 'г', 'h': 'х', 'i': 'и', 'j': 'ј', 'k': 'к',
    'l': 'л', 'lj': 'љ', 'm': 'м', 'n': 'н', 'nj': 'њ', 'o': 'о', 'p': 'п',
    'r': 'р', 's': 'с', 'š': 'ш', 't': 'т', 'u': 'у', 'v': 'в', 'z': 'з',
    'ž': 'ж', 'dž': 'џ'
};

const cyrillicToLatinMap = {
    'а': 'a', 'б': 'b', 'ц': 'c', 'ч': 'č', 'ћ': 'ć', 'д': 'd', 'ђ': 'đ',
    'е': 'e', 'ф': 'f', 'г': 'g', 'х': 'h', 'и': 'i', 'ј': 'j', 'к': 'k',
    'л': 'l', 'љ': 'lj', 'м': 'm', 'н': 'n', 'њ': 'nj', 'о': 'o', 'п': 'p',
    'р': 'r', 'с': 's', 'ш': 'š', 'т': 't', 'у': 'u', 'в': 'v', 'з': 'z',
    'ж': 'ž', 'џ': 'dž'
};


// Добавим после объявления массива verbs или перед функциями

// Глобальные переменные для поиска
let searchTimeout = null;
let allVerbsCache = null; // Кэш для быстрого поиска

// Функция для получения всех глаголов с кириллическими версиями для поиска
function getAllVerbsWithCyrillic() {
    if (!allVerbsCache) {
        allVerbsCache = verbs.map(verb => {
            return {
                ...verb,
                cyrillicInfinitive: toCyrillic(verb.infinitive),
                searchText: `${verb.infinitive.toLowerCase()} ${toCyrillic(verb.infinitive).toLowerCase()} ${verb.translation.toLowerCase()}`
            };
        });
    }
    return allVerbsCache;
}

// Функция поиска глаголов
function searchVerbs(query) {
    if (!query || query.trim() === '') {
        return [];
    }
    
    const normalizedQuery = query.toLowerCase().trim();
    const allVerbs = getAllVerbsWithCyrillic();
    
    // Фильтруем по нескольким критериям:
    return allVerbs.filter(verb => {
        // Ищем в латинской форме
        if (verb.infinitive.toLowerCase().includes(normalizedQuery)) {
            return true;
        }
        
        // Ищем в кириллической форме
        if (verb.cyrillicInfinitive.toLowerCase().includes(normalizedQuery)) {
            return true;
        }
        
        // Ищем в переводе
        if (verb.translation.toLowerCase().includes(normalizedQuery)) {
            return true;
        }
        
        // Ищем по первым буквам (и латиница, и кириллица)
        const startsWithLatin = verb.infinitive.toLowerCase().startsWith(normalizedQuery);
        const startsWithCyrillic = verb.cyrillicInfinitive.toLowerCase().startsWith(normalizedQuery);
        
        return startsWithLatin || startsWithCyrillic;
    });
}

// Функция для отображения результатов поиска
function displaySearchResults(results) {
    const resultsContainer = document.getElementById('search-results');
    
    if (results.length === 0) {
        resultsContainer.innerHTML = `
            <div style="padding: 15px; color: #666; text-align: center; font-style: italic;">
                Ничего не найдено
            </div>
        `;
        resultsContainer.style.display = 'block';
        return;
    }
    
    // Ограничиваем количество результатов для производительности
    const limitedResults = results.slice(0, 20);
    
    let html = '<div style="max-height: 200px; overflow-y: auto;">';
    
    limitedResults.forEach(verb => {
        const cyrillicVerb = verb.cyrillicInfinitive;
        const groupColor = getGroupColor(verb.group);
        
        html += `
            <div class="search-result-item" 
                 data-verb="${verb.infinitive}"
                 style="padding: 10px 15px; border-bottom: 1px solid #f1f1f1; cursor: pointer; transition: background-color 0.2s;"
                 onmouseover="this.style.backgroundColor='#f8f9fa'"
                 onmouseout="this.style.backgroundColor='white'"
                 onclick="selectVerbFromSearch('${verb.infinitive}')">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <strong style="color: #e74c3c;">${verb.infinitive}</strong>
                        <span style="color: #3498db; margin-left: 10px;">${cyrillicVerb}</span>
                    </div>
                    <span style="padding: 2px 8px; background: ${groupColor}; color: white; border-radius: 4px; font-size: 0.8em;">
                        ${verb.group}
                    </span>
                </div>
                <div style="font-size: 0.9em; color: #666; margin-top: 5px;">
                    ${verb.translation}
                </div>
            </div>
        `;
    });
    
    if (results.length > 20) {
        html += `
            <div style="padding: 10px 15px; color: #666; text-align: center; font-style: italic; border-top: 1px solid #f1f1f1;">
                Показано 20 из ${results.length} результатов
            </div>
        `;
    }
    
    html += '</div>';
    resultsContainer.innerHTML = html;
    resultsContainer.style.display = 'block';
}

// Функция для получения цвета группы
function getGroupColor(group) {
    const colors = {
        'A': '#3498db', // синий
        'I': '#2ecc71', // зеленый
        'E': '#9b59b6'  // фиолетовый
    };
    return colors[group] || '#95a5a6';
}

// Функция для выбора глагола из результатов поиска
function selectVerbFromSearch(verbInfinitive) {
    // Находим глагол в базе данных
    const verb = verbs.find(v => v.infinitive === verbInfinitive);
    
    if (verb) {
        currentVerb = verb;
        updateVerbDisplay();
        
        // Закрываем результаты поиска
        document.getElementById('search-results').style.display = 'none';
        document.getElementById('verb-search').value = '';
        document.getElementById('search-clear').style.display = 'none';
    }
}

// Обновленная функция для отображения глагола
function updateVerbDisplay() {
    if (!currentVerb) return;
    
    // Обновляем отображение глагола
    document.getElementById('current-verb').textContent = currentVerb.infinitive;
    
    // Отображаем глагол на кириллице
    const cyrillicVerb = toCyrillic(currentVerb.infinitive);
    document.getElementById('current-verb-cyrillic').textContent = cyrillicVerb;
    
    document.getElementById('verb-translation').textContent = currentVerb.translation;
    document.getElementById('verb-group').textContent = getGroupDescription(currentVerb.group);
    document.getElementById('verb-group').style.backgroundColor = getGroupColor(currentVerb.group);
    
    // Сбрасываем аудиоплеер и состояние
    resetAudioPlayer();
    
    // Очищаем все поля ввода и результаты
    clearAllInputs();
    clearAllResults();
    document.getElementById('overall-result').innerHTML = '';
    
    // Предзагружаем аудио
    setTimeout(preloadVerbAudio, 500);
}

// Функция для обработки поиска с задержкой (debounce)
function handleSearchInput() {
    const searchInput = document.getElementById('verb-search');
    const searchClear = document.getElementById('search-clear');
    const query = searchInput.value;
    
    // Показываем/скрываем кнопку очистки
    if (query.trim() !== '') {
        searchClear.style.display = 'block';
    } else {
        searchClear.style.display = 'none';
        document.getElementById('search-results').style.display = 'none';
        return;
    }
    
    // Очищаем предыдущий таймер
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }
    
    // Устанавливаем новый таймер для поиска с задержкой
    searchTimeout = setTimeout(() => {
        if (query.trim() === '') {
            document.getElementById('search-results').style.display = 'none';
            return;
        }
        
        const results = searchVerbs(query);
        displaySearchResults(results);
    }, 300); // Задержка 300мс
}

// Функция для очистки поиска
function clearSearch() {
    document.getElementById('verb-search').value = '';
    document.getElementById('search-results').style.display = 'none';
    document.getElementById('search-clear').style.display = 'none';
}

// Обновляем функцию displayVerb для использования updateVerbDisplay
function displayVerb() {
    currentVerb = getRandomVerb();
    updateVerbDisplay();
}

// Обновляем обработчики событий
document.addEventListener('DOMContentLoaded', function() {
    loadStats();
    displayVerb();
    
    // Назначение обработчиков событий
    document.getElementById('check-all').addEventListener('click', checkAllForms);
    document.getElementById('show-answers').addEventListener('click', showAnswers);
    document.getElementById('clear-all').addEventListener('click', clearAllInputs);
    document.getElementById('next-verb').addEventListener('click', function() {
        resetAudioPlayer();
        displayVerb();
    });
    document.getElementById('reset-stats').addEventListener('click', resetStats);
    document.getElementById('group-filter').addEventListener('change', function() {
        resetAudioPlayer();
        displayVerb();
    });
    document.getElementById('play-verb-audio').addEventListener('click', playVerbAudio);
    
    // Обработчики для поиска
    document.getElementById('verb-search').addEventListener('input', handleSearchInput);
    document.getElementById('search-clear').addEventListener('click', clearSearch);
    
    // Закрытие результатов поиска при клике вне области
    document.addEventListener('click', function(event) {
        const searchContainer = document.querySelector('div:has(#verb-search)');
        const resultsContainer = document.getElementById('search-results');
        
        if (!searchContainer.contains(event.target) && !resultsContainer.contains(event.target)) {
            resultsContainer.style.display = 'none';
        }
    });
    
    // Enter в полях ввода для перехода к следующему
    const inputs = document.querySelectorAll('.conjugation-input');
    inputs.forEach((input, index) => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                if (index < inputs.length - 1) {
                    inputs[index + 1].focus();
                } else {
                    checkAllForms();
                }
            }
        });
    });
    
    // Enter в поле поиска для выбора первого результата
    document.getElementById('verb-search').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const firstResult = document.querySelector('.search-result-item');
            if (firstResult) {
                firstResult.click();
            }
        }
    });
});

function toCyrillic(latin) {
    let result = '';
    let i = 0;
    
    // Сначала обрабатываем диграфы
    const digraphs = ['dž', 'lj', 'nj'];
    
    while (i < latin.length) {
        let found = false;
        
        // Проверяем диграфы
        for (const digraph of digraphs) {
            if (latin.toLowerCase().substring(i, i + digraph.length) === digraph) {
                result += latinToCyrillicMap[digraph];
                i += digraph.length;
                found = true;
                break;
            }
        }
        
        if (!found) {
            // Проверяем одиночные символы
            const char = latin[i].toLowerCase();
            if (char === 'č' || char === 'ć' || char === 'š' || char === 'ž' || char === 'đ') {
                // Для специальных символов с диакритиками
                result += latinToCyrillicMap[char] || char;
            } else {
                // Для обычных символов
                result += latinToCyrillicMap[char] || char;
            }
            i++;
        }
    }
    
    return result;
}

function toLatin(cyrillic) {
    let result = '';
    let i = 0;
    
    // Сначала обрабатываем диграфы
    const cyrillicDigraphs = ['џ', 'љ', 'њ'];
    
    while (i < cyrillic.length) {
        const char = cyrillic[i].toLowerCase();
        
        // Проверяем специальные символы
        if (char === 'џ' || char === 'љ' || char === 'њ') {
            result += cyrillicToLatinMap[char] || char;
        } else if (char === 'č' || char === 'ć' || char === 'š' || char === 'ž' || char === 'đ') {
            // Это уже латиница
            result += char;
        } else {
            // Обычные символы
            result += cyrillicToLatinMap[char] || char;
        }
        i++;
    }
    
    return result;
}

// Нормализация ответа (приведение к латинице для сравнения)
function normalizeAnswer(answer) {
    // Расширенное регулярное выражение для сербской кириллицы
    const serbianCyrillicRegex = /[а-шђћјљњџ]/i;
    
    // Если ответ содержит кириллические символы, конвертируем в латиницу
    if (serbianCyrillicRegex.test(answer)) {
        return toLatin(answer);
    }
    return answer.toLowerCase();
}

// Загрузка статистики
function loadStats() {
    const saved = localStorage.getItem('verbTrainerStats');
    if (saved) {
        stats = JSON.parse(saved);
    }
    updateStatsDisplay();
}

// Сохранение статистики
function saveStats() {
    localStorage.setItem('verbTrainerStats', JSON.stringify(stats));
}

// Обновление отображения статистики
function updateStatsDisplay() {
    document.getElementById('correct-count').textContent = stats.correct;
    document.getElementById('incorrect-count').textContent = stats.incorrect;
    document.getElementById('total-count').textContent = stats.total;
    
    const accuracy = stats.total > 0 ? Math.round((stats.correct / stats.total) * 100) : 0;
    document.getElementById('accuracy').textContent = accuracy + '%';
}

// Функция для получения отфильтрованного списка глаголов
function getFilteredVerbs() {
    const groupFilter = document.getElementById('group-filter').value;
    if (groupFilter === 'all') {
        return verbs;
    }
    return verbs.filter(verb => verb.group === groupFilter);
}

// Функция для выбора случайного глагола
function getRandomVerb() {
    const filteredVerbs = getFilteredVerbs();
    if (filteredVerbs.length === 0) {
        return null;
    }
    return filteredVerbs[Math.floor(Math.random() * filteredVerbs.length)];
}

// Функция для отображения информации о текущем глаголе
function displayVerb() {
    currentVerb = getRandomVerb();
    
    if (!currentVerb) {
        document.getElementById('current-verb').textContent = "Нет глаголов";
        document.getElementById('verb-translation').textContent = "Измените фильтр групп";
        document.getElementById('verb-group').textContent = "";
        return;
    }
    
    document.getElementById('current-verb').textContent = currentVerb.infinitive;
    document.getElementById('verb-translation').textContent = currentVerb.translation;
    document.getElementById('verb-group').textContent = getGroupDescription(currentVerb.group);
    
    // Очищаем все поля ввода и результаты
    clearAllInputs();
    clearAllResults();
    document.getElementById('overall-result').innerHTML = '';

    resetAudioPlayer();
    setTimeout(preloadVerbAudio, 500);
}

// Функция для получения описания группы
function getGroupDescription(group) {
    const descriptions = {
        'A': 'A-группа (-ati)',
        'I': 'I-группа (-iti)',
        'E': 'E-группа (-eti)'
    };
    return descriptions[group] || group;
}

// Очистка всех полей ввода
function clearAllInputs() {
    const inputs = document.querySelectorAll('.conjugation-input');
    inputs.forEach(input => {
        input.value = '';
    });
}

// Очистка всех результатов
function clearAllResults() {
    const results = document.querySelectorAll('.result');
    results.forEach(result => {
        result.innerHTML = '';
        result.style.background = '';
    });
}

// Проверка всех форм
function checkAllForms() {
    if (!currentVerb) return;
    
    let allCorrect = true;
    let correctCount = 0;
    const totalForms = 6;
    
    // Проверяем каждую форму
    const inputs = document.querySelectorAll('.conjugation-input');
    inputs.forEach(input => {
        const person = input.dataset.person;
        const userAnswer = input.value.trim();
        const correctAnswerLatin = currentVerb.conjugations[person].toLowerCase();
        const correctAnswerCyrillic = toCyrillic(correctAnswerLatin);
        const resultDiv = document.querySelector(`.result[data-person="${person}"]`);
        
        // Нормализуем ответ пользователя (приводим к латинице)
        const normalizedUserAnswer = normalizeAnswer(userAnswer);
        const normalizedCorrectAnswer = correctAnswerLatin.toLowerCase();
        
        if (normalizedUserAnswer === normalizedCorrectAnswer && userAnswer !== '') {
            resultDiv.innerHTML = `
                ✓ Правильно! 
                <div style="font-size: 0.9em; margin-top: 5px;">
                    <strong>Латиница:</strong> ${correctAnswerLatin}<br>
                    <strong>Кириллица:</strong> ${correctAnswerCyrillic}
                </div>
            `;
            resultDiv.style.background = '#d4edda';
            resultDiv.style.color = '#155724';
            resultDiv.style.padding = '10px';
            resultDiv.style.borderRadius = '4px';
            correctCount++;
        } else if (userAnswer === '') {
            resultDiv.innerHTML = '⏸️ Не заполнено';
            resultDiv.style.background = '#fff3cd';
            resultDiv.style.color = '#856404';
            resultDiv.style.padding = '10px';
            resultDiv.style.borderRadius = '4px';
            allCorrect = false;
        } else {
            resultDiv.innerHTML = `
                ✗ Неправильно
                <div style="font-size: 0.9em; margin-top: 5px;">
                    <strong>Ваш ответ:</strong> ${userAnswer}<br>
                    <strong>Правильно (лат):</strong> ${correctAnswerLatin}<br>
                    <strong>Правильно (кир):</strong> ${correctAnswerCyrillic}
                </div>
            `;
            resultDiv.style.background = '#f8d7da';
            resultDiv.style.color = '#721c24';
            resultDiv.style.padding = '10px';
            resultDiv.style.borderRadius = '4px';
            allCorrect = false;
        }
    });
    
    // Обновляем статистику
    stats.total++;
    if (allCorrect) {
        stats.correct++;
    } else {
        stats.incorrect++;
    }
    
    // Показываем общий результат
    const overallResult = document.getElementById('overall-result');
    const percentage = Math.round((correctCount / totalForms) * 100);
    
    if (allCorrect) {
        overallResult.innerHTML = `
            <div style="background: #d4edda; color: #155724; padding: 20px; border-radius: 8px; border: 1px solid #c3e6cb; text-align: center;">
                <div style="font-size: 1.5em; margin-bottom: 10px;">🎉 Отлично! Все формы правильные!</div>
                <div>Вы правильно спрягли глагол <strong>${currentVerb.infinitive}</strong></div>
            </div>
        `;
    } else {
        overallResult.innerHTML = `
            <div style="background: #fff3cd; color: #856404; padding: 20px; border-radius: 8px; border: 1px solid #ffeaa7; text-align: center;">
                <div style="font-size: 1.3em; margin-bottom: 10px;">📊 Результат: ${correctCount}/${totalForms} (${percentage}%)</div>
                <div>Продолжайте тренироваться!</div>
            </div>
        `;
    }
    
    updateStatsDisplay();
    saveStats();
}

// Показать все ответы
function showAnswers() {
    if (!currentVerb) return;
    
    const inputs = document.querySelectorAll('.conjugation-input');
    inputs.forEach(input => {
        const person = input.dataset.person;
        // Показываем ответ на латинице (можно изменить на кириллицу если нужно)
        input.value = currentVerb.conjugations[person];
    });
    
    // Автоматически проверяем после показа ответов
    setTimeout(checkAllForms, 100);
}

// Функция для сброса статистики
function resetStats() {
    if (confirm('Вы уверены, что хотите сбросить статистику?')) {
        stats = { correct: 0, incorrect: 0, total: 0 };
        updateStatsDisplay();
        saveStats();
    }
}

// Инициализация тренажера
document.addEventListener('DOMContentLoaded', function() {
    loadStats();
    displayVerb();
    
    // Назначение обработчиков событий
    document.getElementById('check-all').addEventListener('click', checkAllForms);
    document.getElementById('show-answers').addEventListener('click', showAnswers);
    document.getElementById('clear-all').addEventListener('click', clearAllInputs);
    document.getElementById('next-verb').addEventListener('click', displayVerb);
    document.getElementById('reset-stats').addEventListener('click', resetStats);
    document.getElementById('group-filter').addEventListener('change', displayVerb);
    
    // Enter в полях ввода для перехода к следующему
    const inputs = document.querySelectorAll('.conjugation-input');
    inputs.forEach((input, index) => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                if (index < inputs.length - 1) {
                    inputs[index + 1].focus();
                } else {
                    checkAllForms();
                }
            }
        });
    });
});

// Функция для воспроизведения аудио глагола
function playVerbAudio() {
    if (!currentVerb) return;
    
    const audioPlayer = document.getElementById('verb-audio-player');
    const playButton = document.getElementById('play-verb-audio');
    const audioStatus = document.getElementById('audio-status');
    
    // Если аудио уже воспроизводится, ставим на паузу
    if (!audioPlayer.paused && audioPlayer.src) {
        audioPlayer.pause();
        return;
    }
    
    // Если уже есть загруженный правильный файл, просто воспроизводим
    if (audioPlayer.src && !audioPlayer.paused) {
        audioPlayer.play();
        return;
    }
    
    // Конвертируем название глагола в кириллицу для имени файла
    const cyrillicVerb = toCyrillic(currentVerb.infinitive);
    
    // Делаем первую букву заглавной (так как ваши файлы начинаются с заглавной)
    const cyrillicVerbCapitalized = cyrillicVerb.charAt(0).toUpperCase() + cyrillicVerb.slice(1);
    
    // Формируем путь к аудиофайлу
    const audioPath = `uploads/audio/verbs/${currentVerb.group}/${cyrillicVerbCapitalized}.mp3`;
    
    // Устанавливаем источник аудио
    audioPlayer.src = audioPath;
    
    // Показываем статус загрузки
    playButton.disabled = true;
    playButton.innerHTML = '⏳ Загрузка...';
    audioStatus.textContent = 'Загрузка аудио...';
    
    // Настраиваем обработчики событий для аудио
    audioPlayer.oncanplay = function() {
        playButton.disabled = false;
        playButton.innerHTML = '🔊 Произношение';
        audioStatus.textContent = 'Готово к воспроизведению';
        playButton.style.backgroundColor = '#9b59b6';
        
        // Автоматически воспроизводим после загрузки
        audioPlayer.play().catch(function(error) {
            console.error('Ошибка воспроизведения:', error);
            audioStatus.textContent = 'Ошибка воспроизведения';
            playButton.innerHTML = '🔊 Произношение';
            playButton.disabled = false;
        });
    };
    
    audioPlayer.onerror = function() {
        playButton.disabled = false;
        playButton.innerHTML = '🔊 Произношение';
        audioStatus.textContent = 'Аудиофайл не найден';
        playButton.style.backgroundColor = '#95a5a6';
        
        // Для отладки
        console.log('Не удалось загрузить аудиофайл:', audioPath);
        console.log('Проверьте путь:', {
            глагол: currentVerb.infinitive,
            группа: currentVerb.group,
            кириллица: cyrillicVerb,
            кириллицаЗаглавная: cyrillicVerbCapitalized,
            путь: audioPath
        });
    };
    
    audioPlayer.onplay = function() {
        playButton.innerHTML = '⏸️ Остановить';
        audioStatus.textContent = 'Воспроизводится...';
        playButton.style.backgroundColor = '#e74c3c';
    };
    
    audioPlayer.onended = function() {
        playButton.innerHTML = '🔊 Произношение';
        audioStatus.textContent = 'Воспроизведение завершено';
        playButton.style.backgroundColor = '#9b59b6';
    };
    
    audioPlayer.onpause = function() {
        if (audioPlayer.src && audioPlayer.currentTime > 0) {
            playButton.innerHTML = '🔊 Продолжить';
            audioStatus.textContent = 'Пауза';
            playButton.style.backgroundColor = '#9b59b6';
        }
    };
    
    // Пытаемся загрузить аудио
    audioPlayer.load();
}

function resetAudioPlayer() {
    const audioPlayer = document.getElementById('verb-audio-player');
    const playButton = document.getElementById('play-verb-audio');
    const audioStatus = document.getElementById('audio-status');
    
    // Останавливаем воспроизведение
    audioPlayer.pause();
    audioPlayer.src = '';
    
    // Сбрасываем все обработчики ошибок
    audioPlayer.onerror = null;
    audioPlayer.oncanplay = null;
    audioPlayer.onplay = null;
    audioPlayer.onended = null;
    audioPlayer.onpause = null;
    
    // Сбрасываем состояние UI
    playButton.innerHTML = '🔊 Произношение';
    playButton.style.backgroundColor = '#9b59b6';
    playButton.disabled = false;
    audioStatus.textContent = 'Нажмите для прослушивания';
}

function displayVerb() {
    currentVerb = getRandomVerb();
    
    if (!currentVerb) {
        document.getElementById('current-verb').textContent = "Нет глаголов";
        document.getElementById('current-verb-cyrillic').textContent = "";
        document.getElementById('verb-translation').textContent = "Измените фильтр групп";
        document.getElementById('verb-group').textContent = "";
        return;
    }
    
    // Отображаем глагол на латинице
    document.getElementById('current-verb').textContent = currentVerb.infinitive;
    
    // Отображаем глагол на кириллице
    const cyrillicVerb = toCyrillic(currentVerb.infinitive);
    document.getElementById('current-verb-cyrillic').textContent = cyrillicVerb;
    
    document.getElementById('verb-translation').textContent = currentVerb.translation;
    document.getElementById('verb-group').textContent = getGroupDescription(currentVerb.group);
    
    // Сбрасываем аудиоплеер и состояние
    resetAudioPlayer();
    
    // Очищаем все поля ввода и результаты
    clearAllInputs();
    clearAllResults();
    document.getElementById('overall-result').innerHTML = '';
}

// Обновите обработчики событий в конце скрипта
document.addEventListener('DOMContentLoaded', function() {
    loadStats();
    displayVerb();
    
    // Назначение обработчиков событий
    document.getElementById('check-all').addEventListener('click', checkAllForms);
    document.getElementById('show-answers').addEventListener('click', showAnswers);
    document.getElementById('clear-all').addEventListener('click', clearAllInputs);
    document.getElementById('next-verb').addEventListener('click', function() {
        resetAudioPlayer(); // Сбрасываем аудио перед загрузкой нового глагола
        displayVerb();
    });
    document.getElementById('reset-stats').addEventListener('click', resetStats);
    document.getElementById('group-filter').addEventListener('change', function() {
        resetAudioPlayer(); // Сбрасываем аудио при смене фильтра
        displayVerb();
    });
    document.getElementById('play-verb-audio').addEventListener('click', playVerbAudio);
    
    // Enter в полях ввода для перехода к следующему
    const inputs = document.querySelectorAll('.conjugation-input');
    inputs.forEach((input, index) => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                if (index < inputs.length - 1) {
                    inputs[index + 1].focus();
                } else {
                    checkAllForms();
                }
            }
        });
    });
});

// Функция для предварительной загрузки аудио
function preloadVerbAudio() {
    if (!currentVerb) return;
    
    const cyrillicVerb = toCyrillic(currentVerb.infinitive);
    const cyrillicVerbCapitalized = cyrillicVerb.charAt(0).toUpperCase() + cyrillicVerb.slice(1);
    const audioPath = `uploads/audio/verbs/${currentVerb.group}/${cyrillicVerbCapitalized}.mp3`;
    
    // Создаем скрытый аудиоэлемент для предзагрузки
    const preloadAudio = new Audio();
    preloadAudio.src = audioPath;
    preloadAudio.preload = 'auto';
    
    // Для отладки
    console.log('Предзагрузка аудио:', audioPath);
}
</script>