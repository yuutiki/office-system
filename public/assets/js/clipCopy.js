document.getElementById("copy-button").addEventListener("click", copyToClipboard);

async function copyToClipboard() {
    // コピー対象のテキストを取得
    // const textToCopy = document.getElementById("copy-target").value;
    const textToCopy = document.querySelector('[copy-target="true"]').value;


    // ボタンを無効にする
    document.getElementById("copy-button").disabled = true;

    // 成功時のアイコンを表示
    document.getElementById("default-icon").classList.add("hidden");
    document.getElementById("success-icon").classList.remove("hidden");

    // 成功時のツールチップメッセージを表示
    document.getElementById("default-tooltip-message").classList.add("hidden");
    document.getElementById("success-tooltip-message").classList.remove("hidden");

    // Clipboard APIを使用してクリップボードにコピー
    try {
        await navigator.clipboard.writeText(textToCopy);

        // 成功アイコンとツールチップメッセージを一定時間後に元に戻す
        setTimeout(() => {
            document.getElementById("default-icon").classList.remove("hidden");
            document.getElementById("success-icon").classList.add("hidden");
            document.getElementById("copy-button").disabled = false;

            document.getElementById("default-tooltip-message").classList.remove("hidden");
            document.getElementById("success-tooltip-message").classList.add("hidden");
        }, 3000); // 3000ミリ秒 = 3秒後
    } catch (error) {
        console.error("コピーに失敗しました:", error);
        alert("コピーに失敗しました。");
        document.getElementById("copy-button").disabled = false;
    }
}