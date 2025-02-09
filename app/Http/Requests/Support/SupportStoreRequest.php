<?php

namespace App\Http\Requests\Support;

use Illuminate\Foundation\Http\FormRequest;

class SupportStoreRequest extends FormRequest
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

        // 下書きかどうかで必須チェックを分岐
        $isDraft = $this->boolean('is_draft');

        // 基本のバリデーション
        $rules = [
            'client_id' => ['required'],
            'received_at' => ['required', 'date'],
            'user_id' => ['required',],
            'is_draft' => ['required', 'boolean'],
        ];

        // 必須チェックを下書きかどうかで切り替える
        $requiredFields = !$isDraft ? ['required'] : ['nullable'];

        // 下書きでない場合のバリデーション追加
        $rules = array_merge($rules, [
            'title' => array_merge($requiredFields, ['string', 'max:1000']),
            'request_content' => array_merge($requiredFields, ['string', 'max:1000']),
            'response_content' => array_merge($requiredFields, ['string', 'max:1000']),
            'internal_message' => ['nullable', 'string', 'max:1000'],
            'internal_memo1' => ['nullable', 'string', 'max:1000'],

            'client_user_department' => ['nullable', 'string', 'max:100'],
            'client_user_kana_name' => ['nullable', 'string', 'max:100'],

            'support_type_id' => array_merge($requiredFields, ['exists:support_types,id']),
            'support_time_id' => array_merge($requiredFields, ['exists:support_times,id']),
            'product_series_id' => array_merge($requiredFields, ['exists:product_series,id']),
            'product_version_id' => array_merge($requiredFields, ['exists:product_versions,id']),
            'product_category_id' => array_merge($requiredFields, ['exists:product_categories,id']),

            'is_finished' => ['nullable', 'boolean'],
            'is_disclosured' => ['nullable', 'boolean'],
            'is_confirmed' => ['nullable', 'boolean'],
            'is_troubled' => ['nullable', 'boolean'],
            'is_faq_target' => ['nullable', 'boolean'],
        ]);

        return $rules;
    }

    protected function failedValidation($validator)
    {
        session()->flash('error', '入力内容にエラーがあります。');
        parent::failedValidation($validator);
    }

}
