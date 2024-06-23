<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Affiliation2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Affiliation2Controller extends Controller
{
    public function index()
    {
        $affiliation2s = Affiliation2::with('updatedBy')->orderBy('affiliation2_code','asc')->paginate(50);
        return view('masters.affiliation2-index',compact('affiliation2s'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Affiliation2 $affiliation2)
    {
        //
    }

    public function edit(Affiliation2 $affiliation2)
    {
        //
    }

    public function update(Request $request, Affiliation2 $affiliation2)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->all();
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $affiliation2->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(Affiliation2 $affiliation2)
    {
        //
    }
}
