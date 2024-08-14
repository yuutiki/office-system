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
            'tax_status' => 'required|integer|in:0,1,2',
            'invoice_num' => ['nullable', 'string', 'size:13', function ($attribute, $value, $fail) {
                // 入力がある場合は合計が13桁になるかチェック
                if (!is_null($value)) {
                    if (strlen($value) !== 13 || !preg_match('/^T\d{12}$/', $value)) {
                        $fail('インボイス番号は「T」+数字12桁（合計13桁）です。');
                    }
                }
            }],
            'invoice_at' => '',
            'is_stop_trading' => 'sometimes|boolean', // チェックボックスの値が存在し、booleanであることを確認
            'stop_trading_reason' => 'required_if:is_stop_trading,1', // is_stop_tradingが1の場合、stop_trading_reasonは必須
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
