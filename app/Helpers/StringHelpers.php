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
    // Viewでの使用例（Blade）
    // <div>
    //     <p>郵便番号: {{ format_post_code($address->post_code) }}</p>
    // </div>
}






// if (!function_exists('convertUrlsToLinks')) {
//     /**
//      * テキスト中のURLを自動でリンク化する
//      *
//      * @param  string|null  $text
//      * @return string
//      */
//     function convertUrlsToLinks(?string $text): string
//     {
//         if (empty($text)) {
//             return '';
//         }

//         // HTMLエスケープ（XSS対策）
//         $escaped = e($text);

//         // URL検出してリンク化
//         $linked = preg_replace(
//             '/(https?:\/\/[^\s]+)/',
//             '<a href="$1" target="_blank" rel="noopener noreferrer nofollow" class="text-blue-600 underline break-all">$1</a>',
//             $escaped
//         );

//         // 改行維持
//         return nl2br($linked);
//     }
//     // Viewでの使用例（Blade）
//     // <p class="text-gray-800 whitespace-pre-wrap break-words overflow-hidden text-sm">
//     //     {!! convertUrlsToLinks($comment->content) !!}
//     // </p>
// }

if (!function_exists('convertUrlsToLinks')) {
    /**
     * テキスト中のURLを安全にリンク化する
     *
     * @param string|null $text
     * @param int $maxLength 表示テキストの最大長（省略時は200）
     * @return string HTML（既にエスケープ済み）
     */
    function convertUrlsToLinks(?string $text, int $maxLength = 200): string
    {
        if (empty($text)) {
            return '';
        }

        // 入力長チェック（DoS対策）
        $maxInputLength = 10 * 1024; // 10KB など、要調整
        if (mb_strlen($text) > $maxInputLength) {
            $text = mb_substr($text, 0, $maxInputLength);
        }

        // まず全体をエスケープしておく（表示用）
        $escaped = e($text);

        // URLの正規表現（簡易） - http(s) のみを対象にする
        $pattern = '/https?:\/\/[^\s<>{}|\^`"\']+/i';

        $linked = preg_replace_callback($pattern, function ($matches) use ($maxLength) {
            $raw = $matches[0];

            // filter_varで基本チェック（完全ではないが有用）
            if (!filter_var($raw, FILTER_VALIDATE_URL)) {
                // 無効なURLはそのままエスケープ表示（既にエスケープ済みの値が渡される想定だが念のため）
                return e($raw);
            }

            // URLスキームチェック（確実に http/https のみに）
            $scheme = parse_url($raw, PHP_URL_SCHEME);
            if (!in_array(strtolower($scheme), ['http', 'https'], true)) {
                return e($raw);
            }

            // href用にエスケープ（属性値として安全にする）
            $href = htmlspecialchars($raw, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

            // 表示テキストは見やすく短縮（例：長いURLは途中を ... に）
            $display = $raw;
            if (mb_strlen($display) > $maxLength) {
                $display = mb_substr($display, 0, intval($maxLength/2)) . '…' . mb_substr($display, -intval($maxLength/2));
            }
            $display = htmlspecialchars($display, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

            // 最終的に安全な <a> を返す
            return '<a href="' . $href . '" target="_blank" rel="noopener noreferrer nofollow" class="text-blue-600 hover:text-blue-800 underline break-all">' . $display . '</a>';
        }, $escaped);

        // 改行保持
        return nl2br($linked);
    }
    // Viewでの使用例（Blade）
    // <p class="text-gray-800 whitespace-pre-wrap break-words overflow-hidden text-sm">
    //     {!! convertUrlsToLinks($comment->content) !!}
    // </p>
}
