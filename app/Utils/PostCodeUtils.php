<?php

namespace App\Utils;

class PostCodeUtils
{
    /**
     * 郵便番号のフォーマット変換を行うメソッド
     * 
     * @param string|null $postCode
     * @return string|null
     */
    public static function formatPostCode(?string $postCode): ?string
    {
        if (!isset($postCode)) {
            return null;
        }

        $postCode = mb_convert_kana($postCode, "n"); // 半角変換
        $postCode = preg_replace("/[^0-9]/", "", $postCode); // 数字以外を削除

        if (mb_strlen($postCode) != 7) {
            return "郵便番号の桁数が正しくありません";
        }

        $postCode_01 = substr($postCode, 0, 3);
        $postCode_02 = substr($postCode, -4, 4);
        $formattedPostCode = "{$postCode_01}-{$postCode_02}";

        return $formattedPostCode;
    }

    /**
     * バリデーション用の郵便番号パターン
     * 
     * @return string
     */
    public static function postCodePattern(): string
    {
        return '/^\d{3}-\d{4}$/';
    }
}