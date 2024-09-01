<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorporationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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

        // is_stop_trading の整形
        $this->merge([
            'is_stop_trading' => $this->has('is_stop_trading') ? 1 : 0,
        ]);
        
        // is_stop_trading が0の場合、stop_trading_reason をnullに設定
        if ($this->is_stop_trading == 0) {
            $this->merge([
                'stop_trading_reason' => null,
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
            'corporation_num' => 'size:6',
            'corporation_name' => 'required|max:1024',
            'corporation_kana_name' => 'required|max:1024',
            'corporation_short_name' => 'required|max:1024',
            'invoice_num' => ['nullable', 'string', 'size:14', 'regex:/^T\d{13}$/'],
            'invoice_at' => ['nullable', 'date'],
            'is_stop_trading' => 'nullable|boolean',
            'stop_trading_reason' => 'required_if:is_stop_trading,true',
            'tax_status' => 'required|integer|in:0,1,2',
        ];
    }

    protected function failedValidation($validator)
    {
        session()->flash('error', '入力内容にエラーがあります。');
        parent::failedValidation($validator);
    }
}
