<?php

namespace App\Http\Requests\Link;

use Illuminate\Foundation\Http\FormRequest;

class LinkUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'display_name' => 'required|max:20',
            'affiliation2_id' => 'required|exists:affiliation2s,id',
            'display_order' => 'required|integer|min:1|max:99',
            'url' => 'required|url|max:100',
        ];
    }

    public function messages()
    {
        return [
            'display_name.required' => '表示名は必須です。',
            'affiliation2_id.required' => '所属の選択は必須です。',
            'display_order.required' => '表示順は必須です。',
            'url.required' => 'URLは必須です。',
        ];
    }

    protected function failedValidation($validator)
    {
        session()->flash('error', '入力内容にエラーがあります。');
        parent::failedValidation($validator);
    }
}
