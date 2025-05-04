<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Observers\GlobalObserver;
use Carbon\Carbon;

class ProjectRevenue extends Model
{
    use HasFactory;

    // protected $table = 'project_revenue'; // テーブル名

    protected $fillable = ['project_id', 'sales_year_month', 'amount'];

    public static function bulkInsert(array $data)
    {
        // テーブル名を指定して一括挿入
        DB::table('project_revenues')->insert($data);
    }


    /**
     * 会計年度ごとの月別売上を取得
     *
     * @param int $accountingPeriodId
     * @return array
     */
    public static function getMonthlyRevenueByAccountingPeriod(int $accountingPeriodId): array
    {
        $period = AccountingPeriod::findOrFail($accountingPeriodId);

        $revenues = self::selectRaw('DATE_FORMAT(revenue_year_month, "%Y-%m") as ym, SUM(revenue) as total')
            ->whereBetween('revenue_year_month', [$period->period_start_at, $period->period_end_at])
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('total', 'ym')
            ->toArray();

        // 期間内の各月を初期化
        $monthlyRevenue = [];
        $start = Carbon::parse($period->period_start_at)->startOfMonth();
        $end = Carbon::parse($period->period_end_at)->startOfMonth();

        while ($start->lte($end)) {
            $key = $start->format('Y-m');
            $monthlyRevenue[] = $revenues[$key] ?? 0;
            $start->addMonth();
        }

        return $monthlyRevenue;
    }

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
    }


    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
