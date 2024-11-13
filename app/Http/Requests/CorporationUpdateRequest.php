<?php

namespace App\Http\Requests;

use App\Utils\PostCodeUtils;
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
        $postCode = $this->input('corporation_post_code');

        $mergeData = [
            'is_stop_trading' => $this->has('is_stop_trading') ? 1 : 0,
        ];

        // 郵便番号の整形
        if ($postCode) {
            $formattedPostCode = PostCodeUtils::formatPostCode($postCode);
            // フォーマットに失敗した場合（エラーメッセージが返ってきた場合）は元の値を使用
            $postCode = $formattedPostCode === "郵便番号の桁数が正しくありません" ? $postCode : $formattedPostCode;
        }

        // credit_limitの整形
        if ($creditLimit !== null) {
            $mergeData['credit_limit'] = is_numeric($creditLimit) 
                ? $creditLimit 
                : str_replace(',', '', $creditLimit);
        }

        // 取引停止理由の制御
        if (!$this->has('is_stop_trading')) {
            $mergeData['stop_trading_reason'] = null;
        }

        $this->merge($mergeData);

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
            'corporation_memo' => 'nullable',
            'corporation_tax_num' => 'nullable|size:12|numeric',

            'corporation_post_code' => 'nullable',
            'corporation_prefecture_id' => 'nullable',
            'corporation_address1' => 'nullable',
        ];
    }

    protected function failedValidation($validator)
    {
        session()->flash('error', '入力内容にエラーがあります。');
        parent::failedValidation($validator);
    }
}
