<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ClientType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientTypeController extends Controller
{
    public function index()
    {
        $clientTypes = ClientType::with('updatedBy')->orderBy('client_type_code', 'asc')->paginate(50);
        return view('masters.client-type-index',compact('clientTypes'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(ClientType $clientType)
    {
        //
    }

    public function edit(ClientType $clientType)
    {
        //
    }

    public function update(Request $request, ClientType $clientType)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->validate([
            'client_type_code' => 'required|size:2',
            'client_type_name' => 'required|max:20',
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $clientType->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(ClientType $clientType)
    {
        //
    }
}
