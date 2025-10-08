import { setupKanaInput } from '../../components/kana-input';
import { setupAutoResizeTextareas } from '../../components/auto-resize-textarea';


document.addEventListener('DOMContentLoaded', () => {
    // 名前入力時にカナ補助
    setupKanaInput('#first_name', '#first_name_kana');
    setupKanaInput('#last_name', '#last_name_kana');

    setupAutoResizeTextareas();

});