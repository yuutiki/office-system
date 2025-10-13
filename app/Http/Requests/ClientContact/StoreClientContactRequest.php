<?php

namespace App\Http\Requests\ClientContact;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientContactRequest extends FormRequest
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
            'post_code' => 'nullable|string|regex:/^\d{3}-?\d{4}$/',
            'prefecture_id' => 'nullable|exists:prefectures,id',
            'address_1' => 'nullable|string|max:255',
            'client_contact_memo' => 'nullable|string',
            'is_retired' => 'boolean',
            'is_billing_receiver' => 'boolean',
            'is_payment_receiver' => 'boolean',
        ];
    }

    /**
     * バリデーション後に自動でフォーマット
     */

    protected function passedValidation(): void
    {
        $this->merge([
            'post_code' => format_post_code($this->post_code),
        ]);
    }

    protected function failedValidation($validator)
    {
        session()->flash('error', '入力内容にエラーがあります。');
        parent::failedValidation($validator);
    }
}
