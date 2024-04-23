    // バリデーション関数
    var validateTelNeo = function (value) {
        return /^[0０]/.test(value) && libphonenumber.isValidNumber(value, 'JP');
    }

    // 整形関数
    var formatTel = function (value) {
        return new libphonenumber.AsYouType('JP').input(value);
    }

    var validateAndFormat = function (inputId) {
        var phoneInput = document.getElementById(inputId);
        if (!phoneInput) {
            console.error('ERROR: Phone input element not found!');
            return;
        }
        var tel = phoneInput.value.trim().replace(/[０-９]/g, function(char) {
            // 全角数字を半角に変換
            return String.fromCharCode(char.charCodeAt(0) - 65248);
        }).replace(/\D/g, ''); // 数字以外の文字を削除
        
        if (!validateTelNeo(tel)) {
            console.error('ERROR: Invalid phone number!');
            return;
        }
        var formattedTel = formatTel(tel);
        console.log('Formatted Phone Number:', formattedTel);
        
        // 入力フィールドに整形された電話番号を表示
        phoneInput.value = formattedTel;
        // 以降 formattedTel を使って登録処理など進める
    }

    // 使い方
    // <input type="text" form="userForm" name="ext_phone" onchange="validateAndFormat('ext_phone')" class="input-secondary" id="ext_phone" value="{{old('ext_phone', $user->ext_phone)}}">
    // 上記のようにフォーマットしたいinput要素に「onchange="validateAndFormat('id属性')" 」を記載するだけ

    // 仕様画面
    // user.edit