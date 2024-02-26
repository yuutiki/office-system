<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorporationStoreRequest extends FormRequest
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
            'corporation_num' => 'size:6',
            'corporation_name' => 'required|max:1024',
            'corporation_kana_name' => 'required|max:1024',
            'corporation_short_name' => 'required|max:1024',
            'credit_limit' => 'numeric',
        ];
    }

    // prepareForValidation メソッドは、フォームリクエストクラス内で指定したバリデーションの前に呼び出されます。
    public function prepareForValidation()
    {
        $creditLimit = $this->input('credit_limit');

        if ($creditLimit !== null) {
            $this->merge([
                'credit_limit' => is_numeric($creditLimit) ? $creditLimit : str_replace(',', '', $creditLimit),
            ]);
        }
    }

    protected function failedValidation($validator)
    {
        session()->flash('error', '入力内容にエラーがあります。');
        parent::failedValidation($validator);
    }



    public function validationData()
    {
        // サニタイズ後のデータを取得
        return $this->all();
    }
}
