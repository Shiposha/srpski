<!-- Навигационное меню -->
<nav>
    <ul>
        <!-- Выпадающее меню для основных разделов -->
        <li class="dropdown">
            <a href="#" class="nav-link dropdown-toggle <?= in_array($page, ['alphabet', 'cases', 'pronouns', 'numbers', 'particles', 'adjectives', 'adverbs', 'verb-biti', 'words', 'sentences']) ? 'active' : '' ?>">
                Темы
            </a>
            <ul class="dropdown-menu">
                <li><a href="?page=alphabet" class="dropdown-link <?= $page == 'alphabet' ? 'active' : '' ?>" data-page="alphabet">Алфавит</a></li>
                <li><a href="?page=cases" class="dropdown-link <?= $page == 'cases' ? 'active' : '' ?>" data-page="cases">Падежи</a></li>
                <li><a href="?page=nouns" class="dropdown-link <?= $page == 'nouns' ? 'active' : '' ?>" data-page="nouns">Существительные</a></li>
                <li><a href="?page=adjectives" class="dropdown-link <?= $page == 'adjectives' ? 'active' : '' ?>" data-page="adjectives">Прилагательные</a></li>
                <li><a href="?page=verb-biti" class="dropdown-link <?= $page == 'verb-biti' ? 'active' : '' ?>" data-page="verb-biti">Глаголы</a></li>
                <li><a href="?page=adverbs" class="dropdown-link <?= $page == 'adverbs' ? 'active' : '' ?>" data-page="adverbs">Наречия</a></li>
                <li><a href="?page=pronouns" class="dropdown-link <?= $page == 'pronouns' ? 'active' : '' ?>" data-page="pronouns">Местоимения</a></li>
                <li><a href="?page=numbers" class="dropdown-link <?= $page == 'numbers' ? 'active' : '' ?>" data-page="numbers">Числа</a></li>
                <li><a href="?page=particles" class="dropdown-link <?= $page == 'particles' ? 'active' : '' ?>" data-page="particles">Служебные слова</a></li>
                <li><a href="?page=time" class="dropdown-link <?= $page == 'time' ? 'active' : '' ?>" data-page="time">Время</a></li>
                <li><a href="?page=words" class="dropdown-link <?= $page == 'words' ? 'active' : '' ?>" data-page="words">Слова</a></li>
                <li><a href="?page=sentences" class="dropdown-link <?= $page == 'sentences' ? 'active' : '' ?>" data-page="sentences">Предложения</a></li>
                <li><a href="?page=simulator" class="dropdown-link <?= $page == 'simulator' ? 'active' : '' ?>" data-page="simulator">Тренажер</a></li>
            </ul>
        </li>
        
        <!-- Выпадающее меню для учебников -->
        <li class="dropdown">
            <a href="#" class="nav-link dropdown-toggle <?= in_array($page, ['serbskiy-za-30-dney', 'ucimo-srpski-1', 'ucimo-srpski-2', 'ucimo-srpski-notebook']) ? 'active' : '' ?>">
                Учебники
            </a>
            <ul class="dropdown-menu">
                <li><a href="?page=serbskiy-za-30-dney" class="dropdown-link <?= $page == 'serbskiy-za-30-dney' ? 'active' : '' ?>">Сербский за 30 дней</a></li>
                <li><a href="?page=govori-srpski" class="dropdown-link <?= $page == 'govori-srpski' ? 'active' : '' ?>">Говори сербски</a></li>
                <li><a href="?page=138-verbs" class="dropdown-link <?= $page == '138-verbs' ? 'active' : '' ?>">138 глаголов</a></li>
                <li><a href="?page=ucimo-srpski-1" class="dropdown-link <?= $page == 'ucimo-srpski-1' ? 'active' : '' ?>">Учим Сербский 1</a></li>
                <li><a href="?page=ucimo-srpski-2" class="dropdown-link <?= $page == 'ucimo-srpski-2' ? 'active' : '' ?>">Учим Сербский 2</a></li>
                <li><a href="?page=ucimo-srpski-notebook" class="dropdown-link <?= $page == 'ucimo-srpski-notebook' ? 'active' : '' ?>">Учебная тетрадь</a></li>
            </ul>
        </li>
        
        <!-- Выпадающее меню для полезных ссылок -->
        <li class="dropdown">
            <a href="#" class="nav-link dropdown-toggle <?= in_array($page, ['links', 'resources', 'external-links']) ? 'active' : '' ?>">
                Ссылки
            </a>
            <ul class="dropdown-menu">
                <li><a href="https://disk.yandex.ru/d/IEGnJgBNMRBnqA" target="_blank" class="dropdown-link" rel="noopener noreferrer">Глаголы группы A</a></li>
                <li><a href="https://disk.yandex.ru/d/08VesMj9jCHPEg" target="_blank" class="dropdown-link" rel="noopener noreferrer">Глаголы группы I</a></li>
                <li><a href="https://disk.yandex.ru/d/5bYCHFQ_ZB43vg" target="_blank" class="dropdown-link" rel="noopener noreferrer">Глаголы группы E</a></li>
                <!-- <li><a href="?page=links" class="dropdown-link <?= $page == 'links' ? 'active' : '' ?>" data-page="links">Все ссылки</a></li> -->
                <li><a href="https://glosbe.com/sr/ru" target="_blank" class="dropdown-link" rel="noopener noreferrer">Сербско-русский словарь</a></li>
                <!-- <li><a href="https://www.italki.com/" target="_blank" class="dropdown-link" rel="noopener noreferrer">Italki (языковая практика)</a></li> -->
                <!-- <li><a href="https://www.rts.rs/" target="_blank" class="dropdown-link" rel="noopener noreferrer">RTS (сербское ТВ)</a></li> -->
                <!-- <li><a href="https://www.b92.net/" target="_blank" class="dropdown-link" rel="noopener noreferrer">B92 (сербские новости)</a></li> -->
                <li><a href="https://www.serbianlesson.com/" target="_blank" class="dropdown-link" rel="noopener noreferrer">SerbianLesson.com</a></li>
                <!-- <li><a href="https://www.supernova-soft.com/serbian-language/" target="_blank" class="dropdown-link" rel="noopener noreferrer">Ресурсы по сербскому</a></li> -->
            </ul>
        </li>
        
        <!-- Пункт меню для админки (показываем всем) -->
        <!-- <li><a href="?page=admin-words" class="nav-link <?= $page == 'admin-words' ? 'active' : '' ?>" data-page="admin-words">Добавить слова</a></li> -->
        
    </ul>
</nav>

<script>
// JavaScript для улучшения работы выпадающих меню на мобильных устройствах
document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    const dropdownMenus = document.querySelectorAll('.dropdown-menu');
    
    // Обработчик для всех выпадающих меню
    dropdownToggles.forEach((dropdownToggle, index) => {
        const dropdownMenu = dropdownMenus[index];
        
        if (dropdownToggle && dropdownMenu) {
            // На мобильных устройствах добавляем обработчик клика
            if (window.innerWidth <= 768) {
                dropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isOpen = dropdownMenu.style.display === 'block';
                    
                    // Закрываем все остальные меню
                    dropdownMenus.forEach(menu => {
                        if (menu !== dropdownMenu) {
                            menu.style.display = 'none';
                        }
                    });
                    
                    dropdownMenu.style.display = isOpen ? 'none' : 'block';
                });
            }
        }
    });
    
    // Закрываем меню при клике вне их
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            let isClickInside = false;
            
            dropdownToggles.forEach((dropdownToggle, index) => {
                const dropdownMenu = dropdownMenus[index];
                if (dropdownToggle.contains(e.target) || dropdownMenu.contains(e.target)) {
                    isClickInside = true;
                }
            });
            
            if (!isClickInside) {
                dropdownMenus.forEach(menu => {
                    menu.style.display = 'none';
                });
            }
        }
    });
    
    // Обновляем активное состояние при загрузке страницы
    function updateActiveState() {
        const currentPage = '<?= $page ?>';
        const dropdownLinks = document.querySelectorAll('.dropdown-link');
        
        dropdownLinks.forEach(link => {
            if (link.getAttribute('href').includes(currentPage)) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }
    
    updateActiveState();
});
</script>