// ios-pdf-fix.js - улучшенное определение iOS устройств
document.addEventListener('DOMContentLoaded', function() {
    // Улучшенное определение iOS устройств
    function isIOSDevice() {
        // Проверка по User Agent
        const isIOSUserAgent = /iPad|iPhone|iPod/.test(navigator.userAgent);
        
        // Проверка по платформе (для новых iPad)
        const isIOSPlatform = [
            'iPad Simulator',
            'iPhone Simulator',
            'iPod Simulator',
            'iPad',
            'iPhone',
            'iPod'
        ].includes(navigator.platform) || 
        (navigator.userAgent.includes("Mac") && "ontouchend" in document);
        
        // Проверка по стилю касания
        const isTouchDevice = 'ontouchstart' in window;
        const isAppleDevice = navigator.vendor && navigator.vendor.includes('Apple');
        
        return isIOSUserAgent || isIOSPlatform || (isTouchDevice && isAppleDevice);
    }
    
    // Проверяем, является ли устройство iOS
    if (!isIOSDevice()) return;
    
    console.log('iOS устройство обнаружено, добавляем уведомление...');
    
    // Находим PDF на странице
    function findPDFElements() {
        const elements = [];
        
        // Ищем embed
        const embeds = document.querySelectorAll('embed[type="application/pdf"]');
        embeds.forEach(embed => elements.push({element: embed, url: embed.src}));
        
        // Ищем iframe
        const iframes = document.querySelectorAll('iframe[src*=".pdf"]');
        iframes.forEach(iframe => elements.push({element: iframe, url: iframe.src}));
        
        // Ищем object
        const objects = document.querySelectorAll('object[data*=".pdf"]');
        objects.forEach(object => elements.push({element: object, url: object.data}));
        
        return elements;
    }
    
    const pdfElements = findPDFElements();
    console.log('Найдено PDF элементов:', pdfElements.length);
    
    if (pdfElements.length === 0) return;
    
    // Создаем уведомление для каждого PDF
    pdfElements.forEach((pdf, index) => {
        if (!pdf.url) return;
        
        // Получаем абсолютный URL
        const absoluteUrl = pdf.url.startsWith('http') ? pdf.url : 
                           new URL(pdf.url, window.location.origin).href;
        
        // Создаем уведомление
        const noticeHTML = `
            <div class="ios-pdf-notice" id="ios-pdf-notice-${index}">
                <div class="notice-content">
                    <h4>📱 Рекомендация для пользователей iOS</h4>
                    <p>Для лучшего просмотра PDF на iPhone/iPad рекомендуется использовать альтернативные варианты:</p>
                    <div class="ios-pdf-actions">
                        <a href="${absoluteUrl}" target="_blank" class="pdf-btn primary-btn">
                            📥 Скачать PDF
                        </a>
                        <a href="https://docs.google.com/viewer?url=${encodeURIComponent(absoluteUrl)}" 
                           target="_blank" class="pdf-btn secondary-btn">
                            👁️ Открыть в Google Просмотрщике
                        </a>
                    </div>
                </div>
            </div>
        `;
        
        // Вставляем уведомление перед PDF контейнером
        const pdfContainer = pdf.element.closest('.pdf-container, .pdf-viewer-section');
        if (pdfContainer) {
            pdfContainer.insertAdjacentHTML('beforebegin', noticeHTML);
            console.log('Уведомление добавлено для PDF:', absoluteUrl);
        }
    });
    
    // Дополнительно: пытаемся улучшить отображение PDF на iOS
    function improvePDFOnIOS() {
        const pdfContainers = document.querySelectorAll('.pdf-container');
        pdfContainers.forEach(container => {
            container.style.webkitOverflowScrolling = 'touch';
            container.style.overflow = 'auto';
        });
    }
    
    improvePDFOnIOS();
});