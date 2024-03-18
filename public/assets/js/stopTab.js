// 任意のボタンにフォーカスが当たった時に呼び出される関数
// そのボタン以降のタブ移動を禁止する。shift+TabはOK
function stopTab(event) {
    if (event.keyCode === 9 && !event.shiftKey) { // タブキーが押された場合かつShiftキーが押されていない場合
        event.preventDefault(); // イベントをキャンセルする
    }
}

// 任意のbutton要素に onkeydown="stopTab(event)"　を記述すればOK