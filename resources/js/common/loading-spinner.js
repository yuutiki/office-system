document.addEventListener('DOMContentLoaded', () => {
    const spinner = document.getElementById('my-spinner');

    if (!spinner) return;

    // window.onload でページ完全読み込み後に実行
    window.addEventListener('load', () => {
        spinner.classList.add('opacity-0', 'pointer-events-none');

      // フェードアウト後に完全非表示
        setTimeout(() => {
        spinner.classList.add('hidden');
        }, 700); // Tailwindのduration-700と揃える
    });
});
