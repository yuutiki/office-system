<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ReportType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportTypeController extends Controller
{
    public function index()
    {
        $reportTypes = ReportType::with('updatedBy')->orderBy('report_type_code','asc')->paginate();
        return view('masters.report-type-index',compact('reportTypes'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(reportType $reportType)
    {
        //
    }

    public function edit(reportType $reportType)
    {
        //
    }

    public function update(Request $request, reportType $reportType)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->validate([
            'report_type_code' => 'required|size:2',
            'report_type_name' => 'required|max:20',
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $reportType->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(reportType $reportType)
    {
        //
    }
}
