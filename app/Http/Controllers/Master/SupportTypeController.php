<?php

namespace App\Http\Controllers\Master;

use App\Exports\SupportTypesExport;
use App\Http\Controllers\Controller;
use App\Models\SupportType;
use App\Services\PaginationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SupportTypeController extends Controller
{
    public function index(Request $request, PaginationService $paginationService)
    {
        $perPage = $paginationService->getPerPage($request);

        $typeCode = $request->input('code');
        $typeName = $request->input('name');
        
        $supportTypeQuery = SupportType::sortable()->with('updatedBy');

        if(!empty($typeCode)) {
            $supportTypeQuery->where('code', $typeCode);
        }

        if(!empty($typeName)) {
            $supportTypeQuery->where('name', $typeName);
        }

        $supportTypes = $supportTypeQuery->orderBy('code', 'asc')->paginate($perPage);

        return view('masters.support-type-index',compact('supportTypes', 'request', 'typeCode'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:2|unique:support_types',
            'name' => 'required|string|max:10',
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
            'name' => 'required|max:20',
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $supportType->fill($data)->save();
    
        return redirect()->route('support-type.index')->with('success', '正常に更新しました');
    }

    public function destroy(string $id)
    {
        $client = SupportType::find($id);
        $client->delete();

        return redirect()->route('support-type.index')->with('success', '正常に削除しました');
    }

    public function export()
    {
	    return Excel::download(new SupportTypesExport, 'support-types.csv', \Maatwebsite\Excel\Excel::CSV); 
    }
}
