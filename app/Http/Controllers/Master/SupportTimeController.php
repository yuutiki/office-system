<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SupportTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTimeController extends Controller
{
    public function index()
    {
        $supportTimes = SupportTime::with('updatedBy')->orderBy('time_code', 'asc')->paginate(50);
        return view('masters.support-time-index',compact('supportTimes'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(SupportTime $supportTime)
    {
        //
    }

    public function edit(SupportTime $supportTime)
    {
        //
    }

    public function update(Request $request, SupportTime $supportTime)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->validate([
            'time_code' => 'required|size:2|unique:support_times,time_code,except,time_code',
            'time_name' => 'required|max:20',
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $supportTime->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(SupportTime $supportTime)
    {
        //
    }
}
