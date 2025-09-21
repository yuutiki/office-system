<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Affiliation3;
use App\Models\Affiliation4;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Affiliation4Controller extends Controller
{
    public function index()
    {
        $affiliation4s = Affiliation4::with('updatedBy', 'affiliation3')->orderBy('affiliation4_code','asc')->paginate(50);
        $affiliation3s = Affiliation3::all();
        return view('masters.affiliation4-index',compact('affiliation3s', 'affiliation4s'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'affiliation4_code' => 'required|size:2',
            'affiliation4_prefix' => 'nullable',
            'affiliation4_name' => 'required|max:100',
            'affiliation4_name_kana' => 'nullable|max:100',
            'affiliation4_name_en' => 'nullable|max:100',
            'affiliation4_name_short' => 'nullable|max:100',
            'affiliation3_id' => 'required',
            'is_active' => 'required',
        ]);

        $affiliation4 = new Affiliation4;
        $affiliation4->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function show(Affiliation4 $affiliation4)
    {
        //
    }

    public function edit(Affiliation4 $affiliation4)
    {
        //
    }

    public function update(Request $request, Affiliation4 $affiliation4)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->validate([
            'affiliation4_code' => 'required|size:2',
            'affiliation4_name' => 'required|max:100',
            'affiliation4_name_kana' => 'nullable|max:100',
            'affiliation4_name_en' => 'nullable|max:100',
            'is_active' => 'required',
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $affiliation4->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(Affiliation4 $affiliation4)
    {
        //
    }
}
