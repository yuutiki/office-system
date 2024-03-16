<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractDetailStoreRequest extends FormRequest
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
            'contract_start_at' => 'required',
            'contract_end_at' => 'required',
            'contract_sheet_status_id' => 'required',
            'contract_change_type_id' => 'required',
            'contract_update_type_id' => 'required',
            'contract_partner_type_id' => 'required',
            'contract_amount' => 'required',
            'target_system' => 'max:2000',
            'contract_detail_memo' => 'max:2000',
            'project_id' => 'required',
        ];
    }

        // prepareForValidation メソッドは、フォームリクエストクラス内で指定したバリデーションの前に呼び出されます。
        public function prepareForValidation()
        {
            $contractAmount = $this->input('contract_amount');
    
            if ($contractAmount !== null) {
                $this->merge([
                    'contract_amount' => is_numeric($contractAmount) ? $contractAmount : str_replace(',', '', $contractAmount),
                ]);
            }
        }

    protected function failedValidation($validator)
    {
        session()->flash('error', '入力内容にエラーがあります。');
        parent::failedValidation($validator);
    }
}
