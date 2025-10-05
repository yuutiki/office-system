import { setupKanaInput } from '../../components/kana-input';

document.addEventListener('DOMContentLoaded', () => {
    // 名前入力時にカナ補助
    setupKanaInput('#vendor_name', '#vendor_kana_name');
});