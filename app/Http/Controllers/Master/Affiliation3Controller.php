<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Affiliation3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Affiliation3Controller extends Controller
{
    public function index()
    {
        $affiliation3s = Affiliation3::with('updatedBy')->orderBy('affiliation3_code','asc')->paginate(50);
        return view('masters.affiliation3-index',compact('affiliation3s'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Affiliation3 $affiliation3)
    {
        //
    }

    public function edit(Affiliation3 $affiliation3)
    {
        //
    }

    public function update(Request $request, Affiliation3 $affiliation3)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->validate([
            'Affiliation3_code' => 'required|size:2',
            'Affiliation3_name' => 'required|max:100',
            'Affiliation3_name_kana' => 'required|max:100',
            'Affiliation3_name_en' => 'required|max:100',
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $affiliation3->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(Affiliation3 $affiliation3)
    {
        //
    }
}
