
// resources/js/components/select-all-checkbox.js

/**
 * 一覧ページなどでのチェックボックス操作を共通化するモジュール
 * 
 * @param {string} masterSelector - 全選択チェックボックスのセレクタ
 * @param {string} itemSelector - 個別チェックボックスのセレクタ
 * @param {string} countSelector - 選択件数を表示する要素のセレクタ
 * @param {string|null} modalCountSelector - モーダル用の選択件数表示要素（任意）
 */
export function initCheckboxSelectAll(
    masterSelector = '#selectAllCheckbox',
    itemSelector = '.checkbox-item',
    countSelector = '#selectedCount',
    modalCountSelector = '#modalSelectedCount'
) {
    const masterCheckbox = document.querySelector(masterSelector);
    const checkboxes = document.querySelectorAll(itemSelector);
    const countElement = document.querySelector(countSelector);
    const modalCountElement = document.querySelector(modalCountSelector);

    if (!masterCheckbox || checkboxes.length === 0 || !countElement) {
        console.warn('チェックボックスの要素が見つかりませんでした');
        return;
    }

    const updateSelectedCount = () => {
        const selectedCount = document.querySelectorAll(`${itemSelector}:checked`).length;
        countElement.textContent = selectedCount;
        if (modalCountElement) modalCountElement.textContent = selectedCount;
    };

    masterCheckbox.addEventListener('change', () => {
        checkboxes.forEach(cb => cb.checked = masterCheckbox.checked);
        updateSelectedCount();
    });

    checkboxes.forEach(cb => cb.addEventListener('change', updateSelectedCount));
}
