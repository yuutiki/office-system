window.addEventListener('load', () => {
    const autoResizeTextareas = document.querySelectorAll('[data-auto-resize="true"]');
    autoResizeTextareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight + 2) + 'px';
        });
    
        textarea.addEventListener('mouseover', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight + 2) + 'px';
        });
    });
});