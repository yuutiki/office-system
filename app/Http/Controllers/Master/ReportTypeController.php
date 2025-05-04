<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ReportType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportTypeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = config('constants.perPage');
        $typeCode = $request->input('code');
        $typeName = $request->input('name');

        $reportTypeQuery = ReportType::sortable()->with('updatedBy');

        if(!empty($typeCode)) {
            $reportTypeQuery->where('report_type_code', $typeCode);
        }

        if(!empty($typeName)) {
            $reportTypeQuery->where('report_type_name', $typeName);
        }

        $reportTypes = $reportTypeQuery->paginate($perPage);
        $count = $reportTypes->total();

        return view('masters.report-type-index',compact('reportTypes', 'count', 'typeCode', 'typeName'));
    }

    public function create()
    {
        // 不要
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_type_code' => ['required',
                                    'string',
                                    'regex:/^(0[1-9]|[1-9][0-9])$/',
                                    'unique:report_types'],
            'report_type_name' => ['required',
                                    'string',
                                    'max:10'],
            // 'report_type_name_en' => 'nullable|string|max:10',
        ]);
    
        try {
            DB::transaction(function () use ($validated) {
                ReportType::create($validated);
            });
    
            return redirect()
                ->route('report-type.index')
                ->with('success', '登録が完了しました');
    
        } catch (\Exception $e) {
            return redirect()
                ->route('report-type.index')
                ->with('error', '登録に失敗しました')
                ->withInput()
                ->with('openDrawer', 'create');  // ドロワーを再表示するためのフラグ
        }
    }

    public function show(reportType $reportType)
    {
        // 不要
    }

    public function edit(reportType $reportType)
    {
        // 不要
    }

    public function update(Request $request, reportType $reportType)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->validate([
            'report_type_name' => 'required|max:20',
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $reportType->fill($data)->save();
    
        return redirect()->route('report-type.index')->with('success', '正常に更新しました');
    }

    public function destroy(reportType $reportType)
    {
        //
    }
}
