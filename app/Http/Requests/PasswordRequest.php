<?php

namespace App\Http\Requests;

use App\Models\PasswordPolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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

        return [
            'password' => [
                'required',
                'string',
                'min:' . $passwordPolicy->min_length,
                $passwordPolicy->require_uppercase ? 'regex:/[A-Z]/' : 'password.regex_uppercase',
                $passwordPolicy->require_lowercase ? 'regex:/[a-z]/' : 'password.regex_lowercase',
                $passwordPolicy->require_numeric ? 'regex:/[0-9]/' : 'password.regex_numeric',
                $passwordPolicy->require_symbol ? 'regex:/[\p{P}\p{S}\p{C}]/u' : 'password.regex_symbol',
                function ($attribute, $value, $fail) use ($passwordPolicy) {
                    if ($passwordPolicy->banned_email_use && strpos($value, Auth::user()->email) !== false) {
                        $fail('パスワードにメールアドレスを含めることはできません');
                    }
                },
                // パスワード再利用のバリデーションルールを追加する場合はここに追加
            ],
            'current_password' => 'required',
        ];
    }
}
