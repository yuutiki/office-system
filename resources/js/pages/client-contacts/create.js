import { setupKanaInput } from '../../components/kana-input';

document.addEventListener('DOMContentLoaded', () => {
    // 名前入力時にカナ補助
    setupKanaInput('#first_name', '#first_name_kana');
    setupKanaInput('#last_name', '#last_name_kana');
});