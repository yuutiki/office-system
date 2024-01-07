<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\TradeStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradeStatusController extends Controller
{
    public function index()
    {
        $tradeStatuses = TradeStatus::with('updatedBy')->orderBy('trade_status_code', 'asc')->paginate(50);
        return view('masters.trade-status-index',compact('tradeStatuses'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(TradeStatus $tradeStatus)
    {
        //
    }

    public function edit(TradeStatus $tradeStatus)
    {
        //
    }

    public function update(Request $request, TradeStatus $tradeStatus)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->validate([
            'trade_status_code' => 'required|size:2',
            'trade_status_name' => 'required|max:20',
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $tradeStatus->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(TradeStatus $tradeStatus)
    {
        //
    }
}
