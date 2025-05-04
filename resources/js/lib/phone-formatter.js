// resources/js/lib/phone-formatter.js
import { isValidNumber, AsYouType } from 'libphonenumber-js';

// バリデーション関数
const validateTelNeo = function (value) {
    return /^[0０]/.test(value) && isValidNumber(value, 'JP');
}

// 整形関数
const formatTel = function (value) {
    return new AsYouType('JP').input(value);
}

// validateAndFormat関数をグローバルに公開
window.validateAndFormat = function (inputId) {
    const phoneInput = document.getElementById(inputId);
    if (!phoneInput) {
        console.error('ERROR: Phone input element not found!');
        return;
    }
    
    const tel = phoneInput.value.trim().replace(/[０-９]/g, function(char) {
        // 全角数字を半角に変換
        return String.fromCharCode(char.charCodeAt(0) - 65248);
    }).replace(/\D/g, ''); // 数字以外の文字を削除
    
    if (!validateTelNeo(tel)) {
        console.error('ERROR: Invalid phone number!');
        return;
    }
    
    const formattedTel = formatTel(tel);
    console.log('Formatted Phone Number:', formattedTel);
    
    // 入力フィールドに整形された電話番号を表示
    phoneInput.value = formattedTel;
};

// 読み込み確認用ログ - デバッグのためのコメントは残す
console.log('phone-formatter.js has been loaded');
console.log('validateAndFormat function is available:', typeof window.validateAndFormat);

// DOMContentLoaded イベントでコンソールに表示してみる
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM loaded, validateAndFormat available:', typeof window.validateAndFormat);
});