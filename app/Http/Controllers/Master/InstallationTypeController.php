<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\InstallationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstallationTypeController extends Controller
{
    public function index()
    {
        $installationTypes = InstallationType::with('updatedBy')->paginate(50);
        return view('masters.installation-type-index',compact('installationTypes'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(InstallationType $installationType)
    {
        //
    }

    public function edit(InstallationType $installationType)
    {
        //
    }

    public function update(Request $request, InstallationType $installationType)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        // $data = $request->all();

        $data = $request->validate([
            'type_code' => 'required|size:2',
            'type_name' => 'required|max:20',
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $installationType->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(InstallationType $installationType)
    {
        //
    }
}
