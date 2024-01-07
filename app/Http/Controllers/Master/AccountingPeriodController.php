<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\AccountingPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountingPeriodController extends Controller
{
    public function index()
    {
        $accountingPeriods = AccountingPeriod::with('updatedBy')->get();
        return view('masters.accounting-period-index',compact('accountingPeriods'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(AccountingPeriod $accountingPeriod)
    {
        //
    }

    public function edit(AccountingPeriod $accountingPeriod)
    {
        //
    }

    public function update(Request $request, AccountingPeriod $accountingPeriod)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->all();
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $accountingPeriod->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(AccountingPeriod $accountingPeriod)
    {
        //
    }
}
