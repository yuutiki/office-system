<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorporationUploadRequest extends FormRequest
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
            // バリデーションルールを定義
            'processing_type' => 'required',
            'csv_upload' => 'required|file|mimes:csv|max:10000', // ファイルが必須で、CSVファイルであること、サイズが10,000KB以下であることをバリデーション
        ];
    }

    protected function failedValidation($validator)
    {
        // フラッシュメッセージ用にsessionに保存
        session()->flash('error', 'エラーがあります。');
        parent::failedValidation($validator);
    }

    public function messages()
    {
        return [
            // エラーメッセージの定義
            'processing_type.required' => '処理種別を選択してください。',
            'csv_upload.required' => 'CSVファイルが選択されていません。',
            'csv_upload.file' => 'アップロードされたファイルが無効です。',
            'csv_upload.mimes' => 'CSVファイルを選択してください。',
            'csv_upload.max' => 'ファイルサイズは10,000KB以下にしてください。',
        ];
    }
}
