<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
        return [
            'user_num' => 'required',
            'user_name' => 'required',
            'user_kana_name' => 'required',
            'employee_status_id' => 'required',
            'email' => 'required|email',
            'affiliation1_id' => 'required',
            'department_id' => 'required',
            'affiliation3_id' => 'required',
            'birth' => 'required',
            'ext_phone' => 'required',
            'int_phone' => ['nullable', 'numeric', 'max:' . config('constants.int_phone_maxlength')],
        ];
    }

    protected function failedValidation($validator)
    {
        session()->flash('error', '入力内容にエラーがあります。');
        parent::failedValidation($validator);
    }
}