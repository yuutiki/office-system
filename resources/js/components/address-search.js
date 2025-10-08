// resources/js/components/address-search.js

/**
 * 郵便番号検索ボタンに住所補完処理を追加する
 * @param {string} selector - 郵便番号ボタンのセレクタ（例: '.js-zip-search'）
 */
export function setupAddressSearch(selector = '.js-zip-search') {
    const buttons = document.querySelectorAll(selector);
    if (buttons.length === 0) return;

    buttons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();

            const zipId = button.dataset.zip;
            const prefId = button.dataset.pref;
            const addressId = button.dataset.address;

            if (!zipId || !prefId || !addressId) {
                console.warn('必要なdata属性が設定されていません');
                return;
            }

            if (typeof AjaxZip3 === 'undefined') {
                alert('住所検索ライブラリ（AjaxZip3）が読み込まれていません。');
                return;
            }

            AjaxZip3.zip2addr(zipId, '', prefId, addressId, '', '');

            AjaxZip3.onSuccess = function() {
                const addressField = document.getElementById(addressId);
                if (addressField) addressField.focus();
            };

            AjaxZip3.onFailure = function() {
                alert('郵便番号に該当する住所が見つかりません');
            };
        });
    });
}
