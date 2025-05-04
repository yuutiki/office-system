<!-- resources/views/sso/generator.blade.php -->
<x-app-layout>


    <div class="container mx-auto py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-center mb-6">キャンパスプラン SSO URL ジェネレーター</h1>
            
            <div class="mb-4">
                <label for="baseUrl" class="block text-gray-700 font-semibold mb-2">ベースURL</label>
                <input 
                    type="text" 
                    id="baseUrl" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100" 
                    value="{{ $baseUrl }}"
                    readonly
                >
                <p class="text-sm text-gray-500 mt-1">SSO処理を行うエンドポイントURL</p>
            </div>
            
            <div class="mb-4">
                <label for="redirectUrl" class="block text-gray-700 font-semibold mb-2">リダイレクト先URL</label>
                <input 
                    type="text" 
                    id="redirectUrl" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md" 
                    value="../controller/1234/5678/schema/className"
                    placeholder="../controller/systemCd/kinoId/schema/className"
                >
                <p class="text-sm text-gray-500 mt-1">例: ../controller/1234/5678/schema/className</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="userKubun" class="block text-gray-700 font-semibold mb-2">ユーザー区分</label>
                    <select id="userKubun" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                        <option value="1">学生 (1)</option>
                        <option value="2">教員 (2)</option>
                    </select>
                </div>
                
                <div>
                    <label for="uid" class="block text-gray-700 font-semibold mb-2">ユーザーID (省略可)</label>
                    <input 
                        type="text" 
                        id="uid" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md" 
                        placeholder="ユーザーID（空白の場合はデフォルト値を使用）"
                        value="TEST00001"
                    >
                </div>
            </div>
            
            <button 
                id="generateBtn" 
                class="w-full bg-blue-600 text-white py-3 rounded-md font-semibold hover:bg-blue-700 transition-colors mb-6"
            >
                URLを生成
            </button>
            
            <div id="resultContainer" class="mt-6 p-4 bg-gray-50 rounded-md hidden">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold text-gray-700">生成されたURL</h3>
                    <button
                        id="copyBtn"
                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition-colors text-sm"
                    >
                        コピー
                    </button>
                </div>
                <div class="p-3 bg-white border border-gray-200 rounded-md overflow-x-auto">
                    <p id="generatedUrl" class="text-sm font-mono break-all"></p>
                </div>
            </div>
            
            <div class="mt-8 text-sm text-gray-600 border-t pt-4">
                <h3 class="font-semibold mb-2">パラメータ説明:</h3>
                <ul class="list-disc pl-5 space-y-1">
                    <li><span class="font-semibold">リダイレクト先URL</span>: SSO認証後に遷移するURL</li>
                    <li><span class="font-semibold">ユーザー区分</span>: ユーザータイプ（学生=1、教員=2）</li>
                    <li><span class="font-semibold">ユーザーID</span>: 特定のユーザーIDでログインさせる場合に指定（省略可能）</li>
                    <li><span class="font-semibold">SessionID</span>: 自動生成される24文字の英数字</li>
                    <li><span class="font-semibold">処理日付</span>: 現在の日付（自動生成）</li>
                </ul>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const generateBtn = document.getElementById('generateBtn');
    const copyBtn = document.getElementById('copyBtn');
    const resultContainer = document.getElementById('resultContainer');
    const generatedUrlElement = document.getElementById('generatedUrl');
    
    // 設定をLaravelから取得
    const baseUrl = "{{ $baseUrl }}";
    const encryptionKey = "{{ $encryptionKey }}";
    
    // 文字列を8文字に調整する（StringUtil.SimplifyString相当）
    function simplifyString(str) {
        let result = str;
        // 8文字以下の場合は0で埋める
        while (result.length < 8) {
            result += '\0';
        }
        // 8文字より長い場合は切り詰める
        return result.substring(0, 8);
    }
    
    // セッションID生成
    function generateSessionId() {
        const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        let result = "";
        for (let i = 0; i < 24; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return result;
    }
    
    // URL生成
    function generateUrl() {
        // フォームから値を取得
        const redirectUrl = document.getElementById('redirectUrl').value.trim();
        const userKubun = document.getElementById('userKubun').value;
        const uid = document.getElementById('uid').value.trim() || '12345';
        
        // セッションID生成
        const sessionId = generateSessionId();
        
        // 現在の日時
        const now = new Date();
        const sysDate = now.getFullYear() + 
                      String(now.getMonth() + 1).padStart(2, '0') + 
                      String(now.getDate()).padStart(2, '0') + 
                      String(now.getHours()).padStart(2, '0') + 
                      String(now.getMinutes()).padStart(2, '0');
        
        // 処理日付
        const procDate = now.getFullYear() + 
                       String(now.getMonth() + 1).padStart(2, '0') + 
                       String(now.getDate()).padStart(2, '0');
        
        // パラメータ文字列 - URL エンコードせずにそのまま使用（C#コードに合わせる）
        const param = `${redirectUrl}&${sessionId}&${userKubun}&${uid}&${sysDate}&NOIDHENKAN`;
        
        // 暗号化キー
        const fixedShareKey = encryptionKey;
        const keyBytes = CryptoJS.enc.Utf8.parse(simplifyString(fixedShareKey));
        
        // DES暗号化
        // C#のDESCryptoServiceProviderと同じ設定を使用
        const encrypted = CryptoJS.DES.encrypt(
            CryptoJS.enc.Utf8.parse(param),
            keyBytes,
            {
                mode: CryptoJS.mode.CBC,
                padding: CryptoJS.pad.Pkcs7,
                iv: keyBytes
            }
        );
        
        // Base64エンコード
        const paramBase64 = encrypted.toString();
        
        // 処理日付のランダム文字列生成
        // C#コードと同じ処理を再現
        const rdmVal = Math.floor(Math.random() * Number.MAX_SAFE_INTEGER);
        const rdmstrpre = rdmVal.toString() + "8734";
        const rdmstrsuf = rdmVal.toString() + "9541";
        const procDateWithSalt = rdmstrpre.substring(0, 4) + procDate + rdmstrsuf.substring(4, 4);
        
        // 処理日付の暗号化
        const procDateEncrypted = CryptoJS.DES.encrypt(
            CryptoJS.enc.Utf8.parse(procDateWithSalt),
            keyBytes,
            {
                mode: CryptoJS.mode.CBC,
                padding: CryptoJS.pad.Pkcs7,
                iv: keyBytes
            }
        );
        
        // URL生成
        // encodeURIComponentは使わずにURLクエリパラメータとして追加
        const url = `${baseUrl}?CP_PARAM=${paramBase64}&CP_PROCDATE=${procDateEncrypted.toString()}`;
        
        return url;
    }
    
    // URLを生成ボタンクリック時
    generateBtn.addEventListener('click', function() {
        try {
            // URL生成
            const url = generateUrl();
            
            // 結果を表示
            generatedUrlElement.textContent = url;
            resultContainer.classList.remove('hidden');
        } catch (error) {
            console.error("URL生成エラー:", error);
            alert("URL生成中にエラーが発生しました。コンソールを確認してください。");
        }
    });
    
    // クリップボードにコピー
    copyBtn.addEventListener('click', function() {
        const urlText = generatedUrlElement.textContent;
        
        // クリップボードにコピー
        if (navigator.clipboard) {
            navigator.clipboard.writeText(urlText)
                .then(() => {
                    copyBtn.textContent = "コピーしました！";
                    setTimeout(() => {
                        copyBtn.textContent = "コピー";
                    }, 2000);
                })
                .catch(err => {
                    console.error('クリップボードへのコピーに失敗しました:', err);
                    fallbackCopyToClipboard(urlText);
                });
        } else {
            fallbackCopyToClipboard(urlText);
        }
    });
    
    // クリップボードAPIが使えない場合のフォールバック
    function fallbackCopyToClipboard(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            const successful = document.execCommand('copy');
            if (successful) {
                copyBtn.textContent = "コピーしました！";
                setTimeout(() => {
                    copyBtn.textContent = "コピー";
                }, 2000);
            } else {
                console.error('コピーに失敗しました');
            }
        } catch (err) {
            console.error('コピー実行中にエラーが発生しました:', err);
        }
        
        document.body.removeChild(textArea);
    }
});
    </script>


<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">SSO URL 検証ツール</h1>
        
        <div class="mb-4">
            <label for="ssoUrl" class="block text-gray-700 font-semibold mb-2">SSO URL:</label>
            <input type="text" id="ssoUrl" placeholder="https://xxx/cpsmart/..." 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div class="mb-6">
            <label for="encryptionKey" class="block text-gray-700 font-semibold mb-2">暗号化キー:</label>
            <input type="text" id="encryptionKey" placeholder="暗号化に使用したキー" 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        
        <button onclick="validateSsoUrl()" 
            class="w-full bg-blue-600 text-white py-3 px-4 rounded-md font-semibold hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            検証
        </button>
        
        <div id="result" class="mt-6 p-5 border border-gray-200 rounded-lg bg-gray-50 hidden"></div>
    </div>
</div>

<script>
    // URLパラメータから暗号化された値を取得する関数
    function getUrlParameter(url, name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        const results = regex.exec(url);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    // DESで複合化する関数
    function decryptDES(encryptedBase64, key) {
        try {
            // キーを8バイトに調整
            const adjustedKey = simplifyString(key);
            const keyBytes = CryptoJS.enc.Utf8.parse(adjustedKey);
            
            // Base64からWordArrayに変換
            const ciphertext = CryptoJS.enc.Base64.parse(encryptedBase64);
            
            // DES-CBCモードで復号化
            const decrypted = CryptoJS.DES.decrypt(
                { ciphertext: ciphertext },
                keyBytes,
                {
                    mode: CryptoJS.mode.CBC,
                    padding: CryptoJS.pad.Pkcs7,
                    iv: keyBytes
                }
            );
            
            // UTF-8文字列として解釈
            try {
                return decrypted.toString(CryptoJS.enc.Utf8);
            } catch (utf8Error) {
                // UTF-8デコードに失敗した場合、16進数から手動で復元
                console.warn("UTF-8デコードに失敗、16進数から復元します:", utf8Error);
                
                const hexStr = decrypted.toString();
                const byteArray = new Uint8Array(hexStr.length / 2);
                
                for (let i = 0; i < hexStr.length; i += 2) {
                    byteArray[i/2] = parseInt(hexStr.substr(i, 2), 16);
                }
                
                // UTF-8バイト配列を文字列に変換
                return new TextDecoder('utf-8').decode(byteArray);
            }
        } catch (error) {
            console.error("復号化エラー:", error);
            return "復号化に失敗しました: " + error.message;
        }
    }

    // 8バイトに調整する関数
    function simplifyString(str) {
        let result = str;
        // 8文字以下の場合は0で埋める
        while (result.length < 8) {
            result += '\0';
        }
        // 8文字より長い場合は切り詰める
        return result.substring(0, 8);
    }

    // 16進数表示を追加するヘルパー関数
    function hexDisplay(str) {
        let result = '';
        for (let i = 0; i < str.length; i++) {
            const hex = str.charCodeAt(i).toString(16).padStart(2, '0');
            result += hex + ' ';
        }
        return result.trim();
    }

    // URLを検証する関数
    function validateSsoUrl() {
        // URLとキーの入力値を取得
        const url = document.getElementById('ssoUrl').value;
        const encryptionKey = document.getElementById('encryptionKey').value;
        
        if (!url || !encryptionKey) {
            alert('URLと暗号化キーを入力してください');
            return;
        }
        
        // URLパラメータを取得
        const paramValue = getUrlParameter(url, 'CP_PARAM');
        const procDateValue = getUrlParameter(url, 'CP_PROCDATE');
        
        if (!paramValue || !procDateValue) {
            document.getElementById('result').innerHTML = 
                `<p class="text-red-600 font-semibold">URLにCP_PARAMまたはCP_PROCDATEが含まれていません</p>`;
            document.getElementById('result').classList.remove('hidden');
            return;
        }
        
        // 復号化
        const decryptedParam = decryptDES(paramValue, encryptionKey);
        const decryptedProcDate = decryptDES(procDateValue, encryptionKey);
        
        // 結果の表示
        let resultHtml = `<h3 class="text-lg font-bold text-gray-800 mb-3">復号化結果:</h3>`;
        
        resultHtml += `<div class="mb-4">
            <p class="font-semibold mb-1 text-gray-700">CP_PARAM (文字列):</p>
            <p class="bg-white p-2 rounded border border-gray-300 break-all font-mono text-sm">${decryptedParam}</p>
        </div>`;
        
        resultHtml += `<div class="mb-4">
            <p class="font-semibold mb-1 text-gray-700">CP_PARAM (16進数):</p>
            <p class="bg-white p-2 rounded border border-gray-300 break-all font-mono text-sm">${hexDisplay(decryptedParam)}</p>
        </div>`;
        
        resultHtml += `<div class="mb-4">
            <p class="font-semibold mb-1 text-gray-700">CP_PROCDATE (文字列):</p>
            <p class="bg-white p-2 rounded border border-gray-300 break-all font-mono text-sm">${decryptedProcDate}</p>
        </div>`;
        
        resultHtml += `<div class="mb-4">
            <p class="font-semibold mb-1 text-gray-700">CP_PROCDATE (16進数):</p>
            <p class="bg-white p-2 rounded border border-gray-300 break-all font-mono text-sm">${hexDisplay(decryptedProcDate)}</p>
        </div>`;
        
        // パラメータを分解して表示
        if (decryptedParam && !decryptedParam.startsWith("復号化に失敗")) {
            const paramParts = decryptedParam.split('&');
            if (paramParts.length >= 6) {
                // リダイレクトURLをBase64でデコード
                try {
                    paramParts[0] = atob(paramParts[0]);
                } catch (e) {
                    console.warn("Base64デコードエラー:", e);
                    // エラー時は元の値を使用
                }
                
                resultHtml += createParamBlock("リダイレクトURL", paramParts[0]);
                resultHtml += createParamBlock("セッションID", paramParts[1]);
                resultHtml += createParamBlock("ユーザー区分", paramParts[2]);
                resultHtml += createParamBlock("ユーザーID", paramParts[3]);
                resultHtml += createParamBlock("システム日時", paramParts[4]);
                resultHtml += createParamBlock("結果文字列", paramParts[5]);
                
                resultHtml += `</div>`;
            }
        }
        
        // 処理日付を抽出 (パターンマッチングを利用)
        if (decryptedProcDate && !decryptedProcDate.startsWith("復号化に失敗")) {
            // 8桁の数字を探す (YYYYMMDD形式)
            const dateMatch = decryptedProcDate.match(/(\d{8})/);
            if (dateMatch && dateMatch[1]) {
                const date = dateMatch[1];
                resultHtml += `<div class="mt-4">
                    <p class="font-semibold mb-1 text-gray-700">処理日付:</p>
                    <p class="bg-white p-2 rounded border border-gray-300 font-mono text-sm">${date}</p>
                </div>`;
                
                // YYYYMMDD形式を読みやすく変換
                if (date.length === 8) {
                    const year = date.substring(0, 4);
                    const month = date.substring(4, 6);
                    const day = date.substring(6, 8);
                    resultHtml += `<p class="text-sm text-gray-600 mt-1">${year}年${month}月${day}日</p>`;
                }
            }
        }
        
        document.getElementById('result').innerHTML = resultHtml;
        document.getElementById('result').classList.remove('hidden');
    }
    
    // パラメータブロックを作成する関数
    function createParamBlock(label, value) {
        return `<div class="bg-gray-50 p-3 rounded border border-gray-200">
            <p class="font-semibold text-sm text-gray-700">${label}:</p>
            <p class="font-mono text-sm break-all">${value}</p>
        </div>`;
    }
</script>
</x-app-layout>
