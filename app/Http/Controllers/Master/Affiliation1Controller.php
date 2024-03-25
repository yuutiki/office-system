<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Affiliation1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Affiliation1Controller extends Controller
{
    public function index()
    {
        $affiliation1s = Affiliation1::with('updatedBy')->orderBy('affiliation1_code', 'asc')->withCount('users')->paginate(50);
        return view('masters.affiliation1-index',compact('affiliation1s'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Affiliation1 $affiliation1)
    {
        //
    }

    public function edit(Affiliation1 $affiliation1)
    {
        //
    }

    public function update(Request $request, Affiliation1 $affiliation1)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->validate([
            'affiliation1_code' => 'required|size:2',
            'affiliation1_prefix' => 'nullable',
            'affiliation1_name' => 'required|max:100',
            'affiliation1_kana_name' => 'max:100',
            'affiliation1_eng_name' => 'max:100',
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $affiliation1->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(Affiliation1 $affiliation1)
    {
        //
    }
}
