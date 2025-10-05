import { setupKanaInput } from '../../components/kana-input';

document.addEventListener('DOMContentLoaded', () => {
    // 名前入力時にカナ補助
    setupKanaInput('#client_name', '#client_kana_name');
});
