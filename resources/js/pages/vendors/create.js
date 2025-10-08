import { setupKanaInput } from '../../components/kana-input';
import { setupAddressSearch } from '../../components/address-search';
import { setupAutoResizeTextareas } from '../../components/auto-resize-textarea';

document.addEventListener('DOMContentLoaded', () => {
    // 名前入力時にカナ補助
    setupKanaInput('#vendor_name', '#vendor_kana_name');

    // 住所検索
    setupAddressSearch(); // .js-zip-search 全部に適用

    // リサイズテキストエリア
    setupAutoResizeTextareas();
});