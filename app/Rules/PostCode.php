<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PostCode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // ハイフンありのパターン
        if (preg_match('/^\d{3}-\d{4}$/', $value)) {
            return;
        }
        
        // ハイフンなしのパターン
        if (preg_match('/^\d{7}$/', $value)) {
            return;
        }
        
        // どちらにも該当しない場合はエラー
        $fail('郵便番号の形式が正しくありません（例：123-4567）');
    }
}
