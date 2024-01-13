// shortcut.add("a",function() {
//     alert("「a」を検知しました！");
// }); 


// ショートカットの定義
shortcut.add("Ctrl+S", function () {
    // 保存ボタンをクリック
    document.getElementById('saveButton').click();
});


shortcut.add("Alt+S", function () {
    // 保存ボタンをクリック
    document.getElementById('searchButton').click();
});






// カナ変換（clientcorporation/）
$(function() {
    $.fn.autoKana('input[name="clientcorporation_name"]', 'input[name="clientcorporation_kana_name"]', {katakana: true});
});

// カナ変換（client/）
$(function() {
    $.fn.autoKana('input[name="client_name"]', 'input[name="client_kana_name"]', {katakana: true});
});

$(function() {
    $.fn.autoKana('input[name="name"]', 'input[name="kana_name"]', {katakana: true});
});

$(function() {
    $.fn.autoKana('input[name="name_{{$user->id}}"]', 'input[name="kana_name_{{$user->id}}"]', {katakana: true});
});

// $(function(){
//     $('#clear').click(function(){
//         $('#clientcorporationform input, #clientcorporationform select, #keepfileform input, #keepfileform select').each(function(){
//           //checkboxまたはradioボタンの時
//           if(this.type == 'checkbox' || this.type == 'radio'){
//             //一括でチェックを外す
//               this.checked = false;
//           }
//           //checkboxまたはradioボタン以外の時
//           else{
//             // val値を空にする
//             $(this).val('');
//           }
//         });
//     });
// });


// $(function(){
//     $('#clear').click(function(){
//         $('#keepfileform input, #keepfileform select').each(function(){
//           //checkboxまたはradioボタンの時
//           if(this.type == 'checkbox' || this.type == 'radio'){
//             //一括でチェックを外す
//               this.checked = false;
//           }
//           //checkboxまたはradioボタン以外の時
//           else{
//             // val値を空にする
//             $(this).val('');
//           }
//         });
//     });
// });

// resetForm.js

$(function () {
    $('#clear').click(function () {
        resetForm('#clientcorporationform');
        resetForm('#keepfileform');
        resetForm('#link-search-form');
        resetForm('#search_form');
        resetForm('#supportform');
        // 別のフォームがあればここで追加
    });
});

function resetForm(formId) {
    $(formId + ' input, ' + formId + ' select').each(function () {
        // checkboxまたはradioボタンの時
        if (this.type == 'checkbox' || this.type == 'radio') {
            // 一括でチェックを外す
            this.checked = false;
        }
        // checkboxまたはradioボタン以外の時
        else {
            // val値を空にする
            $(this).val('');
        }
    });
    // 検索ボタンをクリック
    document.getElementById('search-button').click();
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

    $(document).ready(function () {
        // 一括選択用のチェックボックスがクリックされたときの処理
        $('#selectAllCheckbox').click(function () {
            // 他の全てのチェックボックスの状態を一括で変更
            $('input[name="selectedIds[]"]').prop('checked', this.checked);
        });
    });


    // const autoResizeTextareas = document.querySelectorAll('[data-auto-resize="true"]');
    // autoResizeTextareas.forEach(textarea => {
    //     textarea.addEventListener('input', function() {
    //         this.style.height = 'auto';
    //         this.style.height = (this.scrollHeight + 2) + 'px';
    //     });
    
    //     textarea.addEventListener('mouseover', function() {
    //         this.style.height = 'auto';
    //         this.style.height = (this.scrollHeight + 2) + 'px';
    //     });
    // });
});