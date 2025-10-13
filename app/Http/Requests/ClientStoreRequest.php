<?php

namespace App\Http\Requests;

use App\Rules\PostCode;
use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
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
            'client_num' => 'size:12',
            'client_name' => 'required|max:50',
            'client_kana_name' => 'required|max:50',
            'user_id' => 'required',
            'client_type_id' => 'required',
            'trade_status_id' => 'required',
            'installation_type_id' => 'required',
            'affiliation2' => 'required',
            'post_code' => ['nullable', new PostCode()],
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
