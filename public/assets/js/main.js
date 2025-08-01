// shortcut.add("a",function() {
//     alert("「a」を検知しました！");
// }); 


// ショートカットの定義
shortcut.add("Ctrl+S", function () {
    // 保存ボタンをクリック
    document.getElementById('saveButton').click();
});

shortcut.add("Ctrl+A", function () {
    // 保存ボタンをクリック
    document.getElementById('add-button').click();
});

shortcut.add("Ctrl+F", function () {
    // 検索ボタンをクリック
    document.getElementById('search-button').click();
});

shortcut.add("Ctrl+R", function () {
    // 検索リセットボタンをクリック
    document.getElementById('clear').click();
});

// カナ変換用の関数
$(function() {
    $.fn.autoKana('input[name="corporation_name"]', 'input[name="corporation_kana_name"]', {katakana: true});
    $.fn.autoKana('input[name="client_name"]', 'input[name="client_kana_name"]', {katakana: true});
    $.fn.autoKana('input[name="vendor_name"]', 'input[name="vendor_kana_name"]', {katakana: true});
    $.fn.autoKana('input[name="user_name"]', 'input[name="user_kana_name"]', {katakana: true});
    $.fn.autoKana('input[name="first_name"]', 'input[name="first_name_kana"]', {katakana: true});
    $.fn.autoKana('input[name="last_name"]', 'input[name="last_name_kana"]', {katakana: true});
    $.fn.autoKana('input[name^="name_"]', 'input[name^="kana_name_"]', {katakana: true});
});


// // resetForm.js
// $(function () {
//     $('#clear').click(function () {
//         resetForm('#clientcorporationform');
//         resetForm('#keepfileform');
//         resetForm('#link-search-form');
//         resetForm('#search_form');
//         resetForm('#supportform');
//         // 別のフォームがあればここで追加
//     });
// });

// function resetForm(formId) {
//     $(formId + ' input, ' + formId + ' select').each(function () {
//         // checkboxまたはradioボタンの時
//         if (this.type == 'checkbox' || this.type == 'radio') {
//             // 一括でチェックを外す
//             this.checked = false;
//         }
//         // checkboxまたはradioボタン以外の時
//         else {
//             // val値を空にする
//             $(this).val('');
//         }
//     });
//     // 検索ボタンをクリック
//     document.getElementById('search-button').click();
// }


// resetForm.js - 検索フォーム特化版
document.addEventListener('DOMContentLoaded', function() {
    // クリアボタンのイベントリスナー
    const clearButton = document.getElementById('clear');

    if (clearButton) {
        clearButton.addEventListener('click', function() {
            // 検索フォームをリセット
            resetForm('#clientcorporationform');
            resetForm('#keepfileform');
            resetForm('#link-search-form');
            resetForm('#search_form');
            resetForm('#supportform');
            
            // 検索ボタンをクリック
            const searchButton = document.getElementById('search-button');

            if (searchButton) {
                searchButton.click();
            }
        });
    }
});

/**
 * 検索フォームをリセットする関数
 * @param {string} formSelector - フォームのセレクタ
 */
function resetForm(formSelector) {
    const form = document.querySelector(formSelector);
    if (!form) return; // フォームが存在しない場合は処理をスキップ
    
    // 全ての入力要素を取得
    const inputs = form.querySelectorAll('input, select');
    
    // 各入力要素をリセット
    inputs.forEach(function(input) {
        // チェックボックスまたはラジオボタンの場合
        if (input.type === 'checkbox' || input.type === 'radio') {
            input.checked = false;
        } 
        // hidden以外の場合に値をクリア
        else if (input.type !== 'hidden') {
            input.value = '';
        }
    });

    // ユーザー選択の hidden フィールドと表示用テキストをリセット
    const userIdInput = document.getElementById('selected-user-id');
    if (userIdInput) {
        userIdInput.value = '';
    }

    const userDisplay = document.getElementById('selected-user-display');
    if (userDisplay) {
        const defaultText = userDisplay.dataset.default || 'ユーザーを選択';
        userDisplay.textContent = defaultText;
    }
}









function goBack() {
    window.history.back();
}


// 数値入力時に桁区切りをする場合、input="text"タグで onblur="formatNumberInput(this);" とすることで下記の関数を利用できる。
// 例）<input type="text" onblur="formatNumberInput(this);" pattern="\d*">
window.addEventListener('load', () => {
    window.formatNumberInput = function(inputElement) {
        let inputValue = inputElement.value;
        let numericValue = inputValue.replace(/[^0-9]/g, "");
        formattedValue = numericValue.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
        console.log(formattedValue);
        if (!isNaN(numericValue)) {
            inputElement.value = formattedValue;
            return true;
        } else {
            inputElement.value = "";
            return false;
        }
    };

    // 他の初期化コードなどがあればここに追加

    // $(document).ready(function () {
    //     // 一括選択用のチェックボックスがクリックされたときの処理
    //     $('#selectAllCheckbox').click(function () {
    //         // 他の全てのチェックボックスの状態を一括で変更
    //         $('input[name="selectedIds[]"]').prop('checked', this.checked);
    //     });
    // });
});