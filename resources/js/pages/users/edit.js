import { setupKanaInput } from '../../components/kana-input';

document.addEventListener('DOMContentLoaded', () => {
    // 名前入力時にカナ補助
    setupKanaInput('#user_name', '#user_kana_name');
});