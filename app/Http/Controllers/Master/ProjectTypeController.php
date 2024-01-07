<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ProjectType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectTypeController extends Controller
{
    public function index()
    {
        $projectTypes = ProjectType::with('updatedBy')->orderBy('project_type_code','asc')->paginate();
        return view('masters.project-type-index',compact('projectTypes'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
            'project_type_code' => 'required|size:2',
            'project_type_name' => 'required|max:20',
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $projectType->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(ProjectType $projectType)
    {
        //
    }
}
