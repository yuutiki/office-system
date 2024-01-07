<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Prefecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrefectureController extends Controller
{
    public function index()
    {
        $prefectures = Prefecture::with('updatedBy')->paginate(50);
        return view('masters.prefecture-index',compact('prefectures'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Prefecture $prefecture)
    {
        //
    }

    public function edit(Prefecture $prefecture)
    {
        //
    }

    public function update(Request $request, Prefecture $prefecture)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->all();
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $prefecture->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(Prefecture $prefecture)
    {
        //
    }
}
