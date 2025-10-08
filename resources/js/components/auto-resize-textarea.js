/**
 * 自動リサイズテキストエリアモジュール
 * 
 * 利用方法：
 * import { setupAutoResizeTextareas } from '@/components/auto-resize-textarea';
 * setupAutoResizeTextareas();
 */
export function setupAutoResizeTextareas(selector = '[data-auto-resize="true"]') {
    const DEFAULT_MIN_HEIGHT = 150;

    // 対象要素を取得
    const textareas = document.querySelectorAll(selector);
    if (!textareas.length) return;

    textareas.forEach(textarea => {
        const minHeight = parseInt(textarea.dataset.minHeight) || DEFAULT_MIN_HEIGHT;

        // 初期化
        adjustHeight(textarea, minHeight);

        // 入力イベントで更新
        textarea.addEventListener('input', () => adjustHeight(textarea, minHeight));

        // 初回マウスオーバーで再調整（遅延ロード対策）
        let initialized = false;
        textarea.addEventListener('mouseover', function () {
            if (!initialized) {
                adjustHeight(this, minHeight);
                initialized = true;
            }
        });
    });
}

/**
 * 高さ調整処理
 */
function adjustHeight(element, minHeight) {
    const scrollPosition = window.scrollY;
    element.style.height = 'auto';

    const scrollHeight = element.scrollHeight + 2;
    const newHeight = Math.max(minHeight, scrollHeight);
    element.style.height = `${newHeight}px`;

    // ページのスクロール位置を維持
    window.scrollTo(0, scrollPosition);
}
