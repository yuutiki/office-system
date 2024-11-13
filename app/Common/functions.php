<?php

namespace App\Common;


    // function formatBytes(float $bytes): string
    // {
    //     if ($bytes >= 1024 * 1024 * 1024) {
    //         return number_format($bytes / (1024 * 1024 * 1024), 2) . ' GB';
    //     } elseif ($bytes >= 1024 * 1024) {
    //         return number_format($bytes / (1024 * 1024)) . ' MB';
    //     } elseif ($bytes >= 1024) {
    //         return number_format($bytes / 1024) . ' KB';
    //     } else {
    //         return $bytes . ' Bytes';
    //     }
    // }


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
    
            if (mb_strlen($postCode) != 7) {
                return "郵便番号の桁数が正しくありません";
            }
    
            $postCode_01 = substr($postCode, 0, 3);
            $postCode_02 = substr($postCode, -4, 4);
            
            return "{$postCode_01}-{$postCode_02}";
        }
    }
    
    if (!function_exists('validate_post_code')) {
        /**
         * 郵便番号のバリデーションパターンを返す
         * 
         * @return string
         */
        function validate_post_code(): string
        {
            return '/^\d{3}-\d{4}$/';
        }
    }



