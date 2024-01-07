<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::with('updatedBy')->orderBy('division_code','asc')->paginate(50);
        return view('masters.division-index',compact('divisions'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Division $division)
    {
        //
    }

    public function edit(Division $division)
    {
        //
    }

    public function update(Request $request, Division $division)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->validate([
            'division_code' => 'required|size:2',
            'division_name' => 'required|max:100',
            'division_kana_name' => 'required|max:100',
            'division_eng_name' => 'required|max:100',
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $division->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(Division $division)
    {
        //
    }
}
