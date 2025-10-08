import { setupKanaInput } from '../../components/kana-input';
import { setupAddressSearch } from '../../components/address-search';


document.addEventListener('DOMContentLoaded', () => {
    // 名前入力時にカナ補助
    setupKanaInput('#client_name', '#client_kana_name');

    // 住所検索
    setupAddressSearch(); // .js-zip-search 全部に適用
});