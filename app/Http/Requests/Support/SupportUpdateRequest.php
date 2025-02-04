<?php

namespace App\Http\Requests\Support;

use Illuminate\Foundation\Http\FormRequest;

class SupportUpdateRequest extends FormRequest
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
            'client_num' => ['required'],
            'is_draft' => ['required', 'boolean'],
        ];

        // 下書きではない場合の追加バリデーション
        if (!$isDraft) {
            $rules = array_merge($rules, [
                'client_num' => ['required', 'size:12'],
                'f_received_at' => ['required'],
                'f_title' => ['required', 'max:500'],
                'f_support_type_id' => ['required',],
                'f_support_time_id' => ['required',],
                'f_user_id' => ['required',],
                'f_product_series_id' => ['required',],
                'f_product_version_id' => ['required',],
                'f_product_category_id' => ['required',],
            ]);
        }

        return $rules;
    }

    protected function failedValidation($validator)
    {
        session()->flash('error', '入力内容にエラーがあります。');
        parent::failedValidation($validator);
    }
}
