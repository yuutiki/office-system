<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class ReportStoreRequest extends FormRequest
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
                'report_type_id' => ['required', 'exists:report_types,id'],
                'contact_type_id' => ['required', 'exists:contact_types,id'],
                'contact_at' => ['required', 'date'],
                'report_title' => ['required', 'string', 'max:500'],
                'report_content' => ['required', 'string', 'max:5000'],
                // 'selectedRecipientsId' => ['required', 'array'],
                // 'selectedRecipientsId.*' => ['exists:users,id'],
            ]);
        }

        return $rules;

        // return [
        //     'contact_at' => 'required',
        //     'contact_type_id' => 'required',
        //     'report_type_id' => 'required',
        //     'report_title' => 'required|max:5000',
        //     'report_content' => 'required|max:5000',
        //     'client_representative' => 'max:100',
        // ];
    }

    protected function failedValidation($validator)
    {
        session()->flash('error', '入力内容にエラーがあります。');
        parent::failedValidation($validator);
    }
}
