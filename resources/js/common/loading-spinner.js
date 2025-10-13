document.addEventListener('DOMContentLoaded', () => {
    const spinner = document.getElementById('my-spinner');
    if (!spinner) return;
    
    window.addEventListener('load', () => {
        // フェードアウト開始
        spinner.classList.add('opacity-0', 'pointer-events-none');
        
        // フェードアウト完了後にhiddenではなくdisplay: noneを直接適用
        setTimeout(() => {
            spinner.style.display = 'none';
        }, 700); // Tailwindのduration-700と揃える
    });
});