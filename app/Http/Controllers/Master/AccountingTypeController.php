<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\AccountingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountingTypeController extends Controller
{
    public function index()
    {
        $accountingTypes = AccountingType::with('updatedBy')->orderBy('accounting_type_code', 'asc')->paginate(50);
        return view('masters.accounting-type-index',compact('accountingTypes'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(AccountingType $accountingType)
    {
        //
    }

    public function edit(AccountingType $accountingType)
    {
        //
    }

    public function update(Request $request, AccountingType $accountingType)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->validate([
            'accounting_type_code' => 'required|size:2',
            'accounting_type_name' => 'required|max:20',
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $accountingType->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(AccountingType $accountingType)
    {
        //
    }
}
