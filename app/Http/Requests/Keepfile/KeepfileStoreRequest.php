<?php

namespace App\Http\Requests\Keepfile;


use Illuminate\Foundation\Http\FormRequest;

class KeepfileStoreRequest extends FormRequest
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
            'project_id' => 'required',
            'project_num' => 'required',
            'purpose' => 'required|max:100',
            'keep_at' => 'required|date',
            'return_at' => 'required|date|after:keep_at',
            'keepfile_memo' => 'nullable|max:5000',
            'is_finished' => 'required|',
            'depositor' => 'required',
            'keep_method' => 'nullable',
            'keep_data' => 'nullable',
            'pdf_file' => 'nullable|file|mimes:pdf|max:1024',

            'has_personal_information' => 'nullable', // 将来実装予定
        ];
    }

    protected function failedValidation($validator)
    {
        // フラッシュメッセージ用にsessionに保存
        session()->flash('error', 'エラーがあります。');
        parent::failedValidation($validator);
    }
}
