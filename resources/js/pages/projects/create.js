import { setupAutoResizeTextareas } from '../../components/auto-resize-textarea';

document.addEventListener('DOMContentLoaded', () => {
    // リサイズテキストエリア
    setupAutoResizeTextareas();

    // 4つの日付入力欄で入力が完了しフォーカスが外れたら次の入力欄に値をコピーする
    const dateFields = [
        'proposed_order_date',
        'proposed_delivery_date',
        'proposed_accounting_date',
        'proposed_payment_date'
    ];

    dateFields.forEach((fieldId, index) => {
        if (index === 0) return; // 最初のフィールドはスキップ

        const currentField = document.getElementById(fieldId);
        const previousField = document.getElementById(dateFields[index - 1]);

        // 前のフィールドの値が変更されたときに、次のフィールドに値をセット
        previousField.addEventListener('blur', function() {
            // 入力値が不完全な場合は処理しない
            if (!this.value.match(/^\d{4}-\d{2}$/)) return;
            if (!currentField.value) { // 現在のフィールドが空の場合のみ
                currentField.value = this.value;
            }
        });

        // ページ読み込み時に、前のフィールドに値があり現在のフィールドが空の場合、値をコピー
        if (previousField.value && !currentField.value) {
            currentField.value = previousField.value;
        }
    });
});