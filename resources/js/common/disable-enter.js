// resources/js/common/disable-enter.js

/**
 * フォーム内の全ての input で Enter キーによる送信を無効化
 * ※テキストエリアには影響を与えない
 */
export function disableEnterOnInputs() {
    document.addEventListener('keydown', (event) => {
        const target = event.target;
        if (target.tagName === 'INPUT' && event.key === 'Enter') {
            event.preventDefault();
        }
    });
}
