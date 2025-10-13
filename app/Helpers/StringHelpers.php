<?php

if (!function_exists('format_post_code')) {
    /**
     * 郵便番号のフォーマット変換を行う
     * 
     * @param string|null $postCode
     * @return string|null
     */
    function format_post_code(?string $postCode): ?string
    {
        if (!isset($postCode)) {
            return null;
        }

        $postCode = mb_convert_kana($postCode, "n"); // 全角数字を半角に変換
        $postCode = preg_replace("/[^0-9]/", "", $postCode); // 数字以外を削除

        if (mb_strlen($postCode) !== 7) {
            return null;
        }

        return substr($postCode, 0, 3) . '-' . substr($postCode, 3, 4);
    }
}


// Viewでの使用例（Blade）
// <div>
//     <p>郵便番号: {{ format_post_code($address->post_code) }}</p>
// </div>