<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\AccountingPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountingPeriodController extends Controller
{
    public function index(Request $request)
    {
        // Modelにアクセサを定義しており、期間開始～終了の月数を追加している（duration_months）

        $perPage = config('constants.perPage');
        $periodName = $request->input('code');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $accountingPeriodQuery = AccountingPeriod::sortable()->with('updatedBy');

        if(!empty($periodName)) {
            $accountingPeriodQuery->where('period_name', $periodName);
        }

        $accountingPeriods = $accountingPeriodQuery->paginate($perPage);
        $count = $accountingPeriods->total();

        return view('masters.accounting-period-index',compact('accountingPeriods', 'count', 'periodName', 'startDate', 'endDate'));
    }

    public function create()
    {
        // 不要
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'period_name' => ['required',
                                'string',
                                'unique:accounting_periods'],

            'period_start_at' => ['required','string'],

            'period_end_at' => ['required','string'],
        ]);
    
        try {
            DB::transaction(function () use ($validated) {
                AccountingPeriod::create($validated);
            });
    
            return redirect()
                ->route('accounting-period.index')
                ->with('success', '登録が完了しました');
    
        } catch (\Exception $e) {
            return redirect()
                ->route('accounting-period.index')
                ->with('error', '登録に失敗しました')
                ->withInput()
                ->with('openDrawer', 'create');  // ドロワーを再表示するためのフラグ
        }
    }

    public function show(AccountingPeriod $accountingPeriod)
    {
        // 不要
    }

    public function edit(AccountingPeriod $accountingPeriod)
    {
        // 不要
    }

    public function update(Request $request, AccountingPeriod $accountingPeriod)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->validate([
            'period_start_at' => ['required','string'],

            'period_end_at' => ['required','string'],
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $accountingPeriod->fill($data)->save();
    
        return redirect()->route('accounting-period.index')->with('success', '正常に更新しました');
    }

    public function destroy(AccountingPeriod $accountingPeriod)
    {
        //
    }
}
