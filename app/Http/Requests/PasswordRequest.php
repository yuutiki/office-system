<?php

namespace App\Http\Requests;

use App\Models\PasswordPolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\{Uppercase, Lowercase, RequireNumeric, RequireSymbol}; // 複数選択する場合は波括弧で囲めば一行で書ける

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $passwordPolicy = PasswordPolicy::firstOrFail();

        // $passwordRegex = [
        //     'uppercase' => '/[A-Z]/', // 少なくとも1文字の大文字を含む
        //     'lowercase' => '/[a-z]/', // 少なくとも1文字の小文字を含む
        //     'numeric' => '/[0-9]/', // 少なくとも1文字の数字を含む
        //     'symbol' => '/[\p{P}\p{S}\p{C}]/u', // 少なくとも1文字の記号を含む
        // ];

        $rules = [
            'password' => [
                'required',
                'confirmed',
                'string',
                'min:' . $passwordPolicy->min_length,
                $passwordPolicy->require_uppercase ?  new Uppercase : '', // 大文字ルール
                $passwordPolicy->require_lowercase ?  new Lowercase : '', // 小文字ルール
                $passwordPolicy->require_numeric ?  new RequireNumeric : '', // 数字ルール
                $passwordPolicy->require_symbol ?  new RequireSymbol: '', // 記号ルール
                function ($attribute, $value, $fail) use ($passwordPolicy) {
                    if ($passwordPolicy->banned_email_use && strpos($value, Auth::user()->email) !== false) {
                        $fail(__('パスワードにメールアドレスを含めることはできません'));
                    }
                },
            ],
            'current_password' => 'required|current_password',
        ];
    
        return $rules;

        // return [
        //     'password' => [
        //         'required',
        //         'confirmed',
        //         // 'string',
        //         'min:' . $passwordPolicy->min_length,
        //         $passwordPolicy->require_uppercase ? 'regex:/[A-Z]/' : null,
        //         $passwordPolicy->require_lowercase ? 'regex:/[a-z]/' : null,
        //         $passwordPolicy->require_numeric ? 'regex:/[0-9]/' : null,
        //         $passwordPolicy->require_symbol ? 'regex:/[\p{P}\p{S}\p{C}]/u' : null,
        //         function ($attribute, $value, $fail) use ($passwordPolicy) {
        //             if ($passwordPolicy->banned_email_use && strpos($value, Auth::user()->email) !== false) {
        //                 $fail(__('パスワードにメールアドレスを含めることはできません'));
        //             }
        //         },
        //     ],
        //     'current_password' => 'required|current_password',
        // ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    // public function messages(): array
    // {
    //     $passwordPolicy = PasswordPolicy::firstOrFail();

    //     return [
    //         'password.required' => 'パスワードを入力してください。',
    //         'password.confirmed' => '確認用パスワードが一致しません。',
    //         'password.min' => ':min 文字以上で入力してください。',
    //         'password.regex:/[A-Z]/' => 'パスワードには少なくとも1つの大文字を含めてください。',
    //         'password.regex:/[a-z]/' => 'パスワードには少なくとも1つの小文字を含めてください。',
    //         'password.regex:/[0-9]/' => 'パスワードには少なくとも1つの数字を含めてください。',
    //         'password.regex:/[\p{P}\p{S}\p{C}]/u' => 'パスワードには少なくとも1つの記号を含めてください。',
    //         'current_password.required' => '現在のパスワードを入力してください。',
    //         'current_password.current_password' => '現在のパスワードが正しくありません。',
    //         // パスワード再利用のカスタムエラーメッセージを追加する場合はここに追加
    //     ];

    //     // 大文字ルールのカスタムメッセージを追加
    //     if ($passwordPolicy->require_uppercase) {
    //         $messages['password.regex.uppercase'] = 'パスワードには少なくとも1つの大文字を含めてください。';
    //     }
    // }

    protected function failedValidation($validator)
    {
        // フラッシュメッセージ用にsessionに保存
        session()->flash('error', 'エラーがあります。');
        parent::failedValidation($validator);
    }
}
