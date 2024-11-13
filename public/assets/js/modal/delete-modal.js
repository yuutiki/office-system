// modal-utils.js

/**
 * モーダルの設定と制御を行う関数
 * @param {string} modalId - モーダルのID
 * @param {string} corporationId - 企業ID（キャンセルボタンのIDに使用）
 * @returns {Object} モーダルを開く・閉じる関数を含むオブジェクト
 */
function setupModal(modalId, corporationId) {
    // モーダル要素とキャンセルボタンの取得
    const modal = document.getElementById(modalId);
    const cancelButton = document.getElementById(`cancelButton-${corporationId}`);
    
    // モーダルまたはキャンセルボタンが存在しない場合は処理を終了
    if (!modal || !cancelButton) return;

    // モーダルを開く前にフォーカスされていた要素を記憶する変数
    let previousActiveElement = null;

    /**
     * モーダル内のフォーカス可能な要素を取得する関数
     * @returns {Array} フォーカス可能な要素の配列
     */
    function getFocusableElements() {
        return Array.from(modal.querySelectorAll(
            'a[href], button:not([disabled]), input:not([disabled]), textarea:not([disabled]), select:not([disabled]), details, [tabindex]:not([tabindex="-1"])'
        )).filter(el => !el.hasAttribute('disabled') && el.offsetParent !== null);
    }

    /**
     * フォーカスをモーダル内に閉じ込める関数
     * @param {Event} event - キーボードイベント
     */
    function trapFocus(event) {
        if (event.key === 'Tab' || event.keyCode === 9) {
            const focusableElements = getFocusableElements();
            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];

            // Shift + Tab の場合
            if (event.shiftKey) {
                if (document.activeElement === firstElement || !focusableElements.includes(document.activeElement)) {
                    event.preventDefault();
                    lastElement.focus();
                }
            } 
            // Tab の場合
            else {
                if (document.activeElement === lastElement || !focusableElements.includes(document.activeElement)) {
                    event.preventDefault();
                    firstElement.focus();
                }
            }
        } 
        // Escapeキーでモーダルを閉じる
        else if (event.key === 'Escape') {
            closeModal();
        }
    }

    /**
     * モーダルを開く関数
     */
    function openModal() {
        previousActiveElement = document.activeElement;
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
        cancelButton.focus();
        document.addEventListener('keydown', trapFocus);
    }

    /**
     * モーダルを閉じる関数
     */
    function closeModal() {
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
        document.removeEventListener('keydown', trapFocus);
        if (previousActiveElement) {
            previousActiveElement.focus();
        }
    }

    // モーダルを開くトリガーにイベントリスナーを追加
    document.querySelectorAll(`[data-modal-target="${modalId}"]`).forEach(trigger => {
        trigger.addEventListener('click', openModal);
    });

    // モーダルを閉じるトリガーにイベントリスナーを追加
    document.querySelectorAll(`[data-modal-hide="${modalId}"]`).forEach(trigger => {
        trigger.addEventListener('click', closeModal);
    });

    // モーダル外のクリックでモーダルを閉じる
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    // 公開する関数
    return { openModal, closeModal };
}

// 使用例：
// document.addEventListener('DOMContentLoaded', function() {
//     const { openModal, closeModal } = setupModal('exampleModal', 'exampleCorp');
//     // 必要に応じて openModal, closeModal を使用
// });