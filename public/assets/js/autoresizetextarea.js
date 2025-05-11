window.addEventListener('load', () => {
    const autoResizeTextareas = document.querySelectorAll('[data-auto-resize="true"]');
    const DEFAULT_MIN_HEIGHT = 150; // デフォルトの最小高さ
    
    autoResizeTextareas.forEach(textarea => {
        // データ属性から最小高さを取得
        const minHeight = parseInt(textarea.dataset.minHeight) || DEFAULT_MIN_HEIGHT;
        
        // 初期化時に最小高さを適用
        adjustHeight(textarea, minHeight);
        
        textarea.addEventListener('input', function() {
            adjustHeight(this, minHeight);
        });
        
        let initialized = false;
        textarea.addEventListener('mouseover', function() {
            if (!initialized) {
                adjustHeight(this, minHeight);
                initialized = true;
            }
        });
    });
    
    function adjustHeight(element, minHeight) {
        const scrollPosition = window.scrollY;
        
        element.style.height = 'auto';
        const scrollHeight = element.scrollHeight + 2;
        
        const newHeight = Math.max(minHeight, scrollHeight);
        element.style.height = newHeight + 'px';
        
        window.scrollTo(0, scrollPosition);
    }
});