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

$(function(){
    $('#clear').click(function(){
        $('#clientcorporationform input, #clientcorporationform select, #keepfileform input, #keepfileform select').each(function(){
          //checkboxまたはradioボタンの時
          if(this.type == 'checkbox' || this.type == 'radio'){
            //一括でチェックを外す
              this.checked = false;
          }
          //checkboxまたはradioボタン以外の時
          else{
            // val値を空にする
            $(this).val('');
          }
        });
    });
});


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


// 数値入力時に桁区切りをする場合、input="text"タグで onblur="formatNumberInput(this);" とすることで下記の関数を利用できる。
function formatNumberInput(inputElement) {
    let inputValue = inputElement.value;
    let numericValue = inputValue.replace(/[^0-9]/g, "");
    formattedValue = numericValue.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
    console.log(formattedValue);
    if (!isNaN(numericValue)) {
        inputElement.value = formattedValue;
        return true;
    } else {
        inputElement.value = ""; // 数値以外が入力された場合は空にするか、適切な処理を行う
        return false;
    }
}