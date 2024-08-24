<?php

namespace App\Http\Requests\ClientPerson;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientPersonRequest extends FormRequest
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
            'client_num' => 'required|exists:clients,client_num',
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name_kana' => 'required|string|max:255|regex:/^[ァ-ヶー]+$/u',
            'first_name_kana' => 'required|string|max:255|regex:/^[ァ-ヶー]+$/u',
            'division_name' => 'nullable|string|max:255',
            'position_name' => 'nullable|string|max:255',
            'tel1' => 'nullable|string|regex:/^[0-9-]+$/|max:20',
            'tel2' => 'nullable|string|regex:/^[0-9-]+$/|max:20',
            'fax1' => 'nullable|string|regex:/^[0-9-]+$/|max:20',
            'fax2' => 'nullable|string|regex:/^[0-9-]+$/|max:20',
            'int_tel' => 'nullable|string|max:20',
            'phone' => 'nullable|string|regex:/^[0-9-]+$/|max:20',
            'mail' => 'nullable|email|max:255',
            'head_post_code' => 'nullable|string|regex:/^\d{3}-?\d{4}$/',
            'head_prefecture' => 'nullable|exists:prefectures,id',
            'head_addre1' => 'nullable|string|max:255',
            'person_memo' => 'nullable|string',
            'is_retired' => 'boolean',
            'is_billing_receiver' => 'boolean',
            'is_payment_receiver' => 'boolean',
            'is_support_info_receiver' => 'boolean',
            'is_closing_info_receiver' => 'boolean',
            'is_exhibition_info_receiver' => 'boolean',
            'is_cloud_info_receiver' => 'boolean',
        ];
    }

    protected function failedValidation($validator)
    {
        session()->flash('error', '入力内容にエラーがあります。');
        parent::failedValidation($validator);
    }
}
