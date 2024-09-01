<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * バリデーションの前にデータを準備
     * prepareForValidation メソッドは、Illuminate\Foundation\Http\FormRequest クラスで定義されているメソッドです。
     * フォームリクエストクラス内で指定したバリデーションの前に呼び出されます。
     * @return void
     */
    protected function prepareForValidation()
    {
        // corporation_num を除外
        $this->replace($this->except('corporation_num'));

        $creditLimit = $this->input('credit_limit');

        if ($creditLimit !== null) {
            $this->merge([
                'credit_limit' => is_numeric($creditLimit) ? $creditLimit : str_replace(',', '', $creditLimit),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'corporation_name' => ['required', 'string', 'max:1024'],
            'corporation_kana_name' => ['required', 'string', 'max:1024'],
            'corporation_short_name' => ['required', 'string', 'max:1024'],
            'tax_status' => ['nullable', 'integer', Rule::in([0, 1, 2])],
            'invoice_num' => ['nullable', 'string', 'size:14', 'regex:/^T\d{13}$/'],
            'invoice_at' => ['nullable', 'date'],
            'is_stop_trading' => ['sometimes', 'boolean'], // チェックボックスの値が存在し、booleanであることを確認
            'stop_trading_reason' => ['required_if:is_stop_trading,1', 'string'], // is_stop_tradingが1の場合、stop_trading_reasonは必須
            'credit_limit' => ['nullable', 'numeric'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'invoice_num.regex' => 'インボイス番号は「T」+数字13桁（合計14桁）です。',
        ];
    }

    protected function failedValidation($validator)
    {
        session()->flash('error', '入力内容にエラーがあります。');
        parent::failedValidation($validator);
    }
}