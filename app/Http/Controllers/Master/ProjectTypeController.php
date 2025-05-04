<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ProjectType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectTypeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = config('constants.perPage');
        $typeCode = $request->input('code');
        $typeName = $request->input('name');

        $projectTypeQuery = ProjectType::sortable()->with('updatedBy');

        if(!empty($typeCode)) {
            $projectTypeQuery->where('project_type_code', $typeCode);
        }

        if(!empty($typeName)) {
            $projectTypeQuery->where('project_type_name', $typeName);
        }

        $projectTypes = $projectTypeQuery->paginate($perPage);
        $count = $projectTypes->total();

        return view('masters.project-type-index',compact('projectTypes', 'count', 'typeCode', 'typeName'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_type_code' => ['required',
                                    'string',
                                    'regex:/^(0[1-9]|[1-9][0-9])$/',
                                    'unique:project_types'],
            'project_type_name' => ['required',
                                    'string',
                                    'max:10'],
            // 'project_type_name_en' => 'nullable|string|max:10',
        ]);
    
        try {
            DB::transaction(function () use ($validated) {
                ProjectType::create($validated);
            });
    
            return redirect()
                ->route('project-type.index')
                ->with('success', '登録が完了しました');
    
        } catch (\Exception $e) {
            return redirect()
                ->route('project-type.index')
                ->with('error', '登録に失敗しました')
                ->withInput()
                ->with('openDrawer', 'create');  // ドロワーを再表示するためのフラグ
        }
    }

    public function show(ProjectType $projectType)
    {
        //
    }

    public function edit(ProjectType $projectType)
    {
        //
    }

    public function update(Request $request, ProjectType $projectType)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->validate([
            // 'project_type_code' => 'required|size:2',
            'project_type_name' => 'required|max:20',
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $projectType->fill($data)->save();
    
        return redirect()->route('project-type.index')->with('success', '正常に更新しました');
    }

    public function destroy(ProjectType $projectType)
    {
        //
    }
}
