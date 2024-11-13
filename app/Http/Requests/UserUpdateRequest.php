<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        // ルートパラメータから直接IDを取得
        // $userId = $this->route('user');
        return [
            'user_name' => 'required',
            'user_kana_name' => 'required',
            'int_phone' => 'nullable',
            'ext_phone' => 'nullable',
            'affiliation1_id' => 'required',
            'affiliation2_id' => 'nullable',
            'affiliation3_id' => 'nullable',
            'employee_status_id' => 'required',
            'is_enabled' => 'nullable|boolean',
            'password_change_required' => 'nullable|boolean',
            'birth' => 'required|date',
            'access_ip' => 'nullable|ip',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->route('user')),
            ],
        ];
    }

    protected function failedValidation($validator)
    {
        session()->flash('error', '入力内容にエラーがあります。');
        parent::failedValidation($validator);
    }
}
