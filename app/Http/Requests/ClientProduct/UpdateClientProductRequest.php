<?php

namespace App\Http\Requests\ClientProduct;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientProductRequest extends FormRequest
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
            'client_id' => 'required|exists:clients,id',
            'product_id' => 'required|exists:products,id',
            'product_version_id' => 'required|exists:product_versions,id',
            'is_customized' => 'required|boolean',
            'is_contracted' => 'required|boolean',
            'quantity' => 'required|integer|min:0|max:99',
            'install_memo' => 'nullable|string|max:10000',
        ];
    }

    protected function failedValidation($validator)
    {
        session()->flash('error', '入力内容にエラーがあります。');
        parent::failedValidation($validator);
    }
}
