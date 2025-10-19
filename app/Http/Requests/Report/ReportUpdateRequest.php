<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class ReportUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // 認可はPolicyで別途チェック
    }

    public function rules(): array
    {
        return [
            'report_title' => ['required', 'string', 'max:255'],
            'report_content' => ['required', 'string'],
            'contact_at' => ['required', 'date'],
            'client_id' => ['nullable', 'exists:clients,id'],
            // 'client_contact_ids' => ['nullable', 'array'],
            'selectedRecipientsId' => ['nullable', 'array'],
        ];

        return $rules;
    }

    protected function failedValidation($validator)
    {
        session()->flash('error', '入力内容にエラーがあります。');
        parent::failedValidation($validator);
    }
}
