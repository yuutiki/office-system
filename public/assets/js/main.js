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