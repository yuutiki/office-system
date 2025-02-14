<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SupportType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupportTypeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = config('constants.perPage');
        $typeCode = $request->input('code');
        $typeName = $request->input('name');
        
        $supportTypeQuery = SupportType::sortable()->with('updatedBy');

        if(!empty($typeCode)) {
            $supportTypeQuery->where('type_code', $typeCode);
        }

        if(!empty($typeName)) {
            $supportTypeQuery->where('type_name', $typeName);
        }

        $supportTypes = $supportTypeQuery->orderBy('type_code', 'asc')->paginate($perPage);
        $count = $supportTypes->total();

        return view('masters.support-type-index',compact('supportTypes', 'count', 'request', 'typeCode'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_code' => 'required|string|max:2|unique:support_types',
            'type_name' => 'required|string|max:10',
        ]);
    
        try {
            DB::transaction(function () use ($validated) {
                SupportType::create($validated);
            });
    
            return redirect()
                ->route('support-type.index')
                ->with('success', '登録が完了しました');
    
        } catch (\Exception $e) {
            return redirect()
                ->route('support-type.index')
                ->with('error', '登録に失敗しました')
                ->withInput()
                ->with('openDrawer', 'create');  // ドロワーを再表示するためのフラグ
        }
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
            // 'type_code' => 'required|size:2',
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
