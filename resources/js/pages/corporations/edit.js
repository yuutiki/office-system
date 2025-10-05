import { setupKanaInput } from '../../components/kana-input';

document.addEventListener('DOMContentLoaded', () => {
    // 名前入力時にカナ補助
    setupKanaInput('#corporation_name', '#corporation_kana_name');
});