<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SupportType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTypeController extends Controller
{
    public function index()
    {
        $supportTypes = SupportType::with('updatedBy')->orderBy('type_code', 'asc')->paginate(50);
        return view('masters.support-type-index',compact('supportTypes'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(SupportType $supportType)
    {
        //
    }

    public function edit(SupportType $supportType)
    {
        //
    }

    public function update(Request $request, SupportType $supportType)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->validate([
            'type_code' => 'required|size:2',
            'type_name' => 'required|max:20',
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $supportType->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(SupportType $supportType)
    {
        //
    }
}
