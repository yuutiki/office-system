<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
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
            'project_name' => 'required|max:100',
            'client_id' => 'required',
            'project_name' => 'required|max100',
            'sales_stage_id' => 'required',
            'project_type_id' => 'required',
            'accounting_type_id' => 'required',
            'distribution_type_id' => 'required',
            'billing_corporation_id' => 'required',
            'proposed_order_date' => '',
            'proposed_delivery_date' => '',
            'proposed_accounting_date' => '',
            'proposed_payment_date' => '',
            'project_memo' => 'max:500',
            'account_company_id' => 'required',
            'account_department_id' => 'required',
            'account_division_id' => 'required',
            'account_user_id' => 'required',
        ];
    }
    

    protected function failedValidation($validator)
    {
        session()->flash('error', '入力内容にエラーがあります。');
        parent::failedValidation($validator);
    }
}
