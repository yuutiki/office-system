<?php

// 文字列操作関連 > 郵便番号操作
if (!function_exists('formatPostalCode')) {
    function formatPostalCode($postalCode) {
        if (!isset($postalCode)) {
            return null;
        }

        // 全角数字を半角に変換
        $postalCode = mb_convert_kana($postalCode, "n");
        
        // 数字以外の文字を除去
        $postalCode = preg_replace('/[^0-9]/', '', $postalCode);
        
        // 7桁の数字であることを確認
        if (strlen($postalCode) == 7) {
            return substr($postalCode, 0, 3) . '-' . substr($postalCode, 3);
        }
        
        // 形式が正しくない場合はエラーメッセージを返す
        return "郵便番号の桁数が正しくありません";
    }
}


//  //郵便番号のフォーマット変換を行うメソッド
//  public static function formatPostCode($postCode)
//  {
//      if (!isset($postCode)) {
//          return null;
//      }

//      $postCode = mb_convert_kana($postCode, "n"); // 半角変換
//      $postCode = preg_replace("/[^0-9]/", "", $postCode); // 数字以外を削除

//      if (mb_strlen($postCode) != 7) {
//          return "郵便番号の桁数が正しくありません";
//      }

//      $postCode_01 = substr($postCode, 0, 3);
//      $postCode_02 = substr($postCode, -4, 4);
//      $formattedPostCode = "{$postCode_01}-{$postCode_02}";

//      return $formattedPostCode;
//  }