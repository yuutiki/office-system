<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ContactType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactTypeController extends Controller
{
    public function index()
    {
        $contactTypes = ContactType::with('updatedBy')->orderBy('contact_type_code', 'asc')->paginate(50);
        return view('masters.contact-type-index',compact('contactTypes'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(contactType $contactType)
    {
        //
    }

    public function edit(contactType $contactType)
    {
        //
    }

    public function update(Request $request, contactType $contactType)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->validate([
            'contact_type_code' => 'required|size:2',
            'contact_type_name' => 'required|max:20',
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $contactType->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(contactType $contactType)
    {
        //
    }
}
