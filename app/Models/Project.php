<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add
use Illuminate\Support\Str;
use App\Observers\GlobalObserver;
use Illuminate\Support\Facades\Log;

class Project extends Model
{
    use HasFactory,Sortable;

    //ソート用に使うカラムを指定
    public $sortable = [
        'project_num',
        'project_name',
        'sales_stage_id',
    ];

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
    }

    // protected $dates = ['your_date_field']; // もしくはモデルで日付として扱うフィールド

    public function getYourDateFieldAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m'); // 例: 2021-12 の形式に変更
    }

    public static function generateProjectNumber($clientNum)
    {
        // $suffix = strtoupper(Str::substr($prefix_code, 0, 1));
        $lastProject = Project::where('project_num', 'like', "$clientNum%")
            ->orderBy('project_num', 'desc')
            ->first();

        if ($lastProject) {
            $lastSerialNumber = (int) Str::substr($lastProject->project_num, -4);
            $newSerialNumber = str_pad($lastSerialNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newSerialNumber = '0001';
        }

        return "$clientNum-$newSerialNumber";
    }

    // プロジェクトごとの金額合計を取得するアクセサ
    public function getTotalAmountAttribute()
    {
        return $this->projectRevenues->sum('revenue');
    }

    public function scopeActive($query)
    {
        return $query->where('sales_stage_id', '!=', '6');
    }



    
    // 検索ロジック
    public function scopeFilter($query, $filters)
    {
        if (isset($filters['project_num'])) {
            $query->where('project_num', 'like', '%' . $filters['project_num'] . '%');
        }

        if (isset($filters['project_name'])) {
            $query->where('project_name', 'like', '%' . $filters['project_name'] . '%');
        }

        if (isset($filters['client_name'])) {
            $spaceConversion = mb_convert_kana($filters['client_name'], 's');
            $query->whereHas('client', function($query) use ($spaceConversion) {
                $query->where(function($q) use ($spaceConversion) {
                    $q->orWhere('client_name', 'like', '%' . $spaceConversion . '%')
                    ->orWhere('client_kana_name', 'like', '%' . $spaceConversion . '%');
                    // ->orWhere('client_short_name', 'like', '%' . $spaceConversion . '%');
                });
            });
        }

        if (isset($filters['invoice_num'])) {
            $query->where('invoice_num', 'like', '%' . $filters['invoice_num'] . '%');
        }

        if (isset($filters['sales_stage_ids'])) {
            $query->whereIn('sales_stage_id', $filters['sales_stage_ids']);
        }

        if (isset($filters['project_type_ids'])) {
            $query->whereIn('project_type_id', $filters['project_type_ids']);
        }

        if (isset($filters['accounting_type_ids'])) {
            $query->whereIn('accounting_type_id', $filters['accounting_type_ids']);
        }

        if (isset($filters['accounting_period'])) {
            $accountingPeriod = AccountingPeriod::find($filters['accounting_period']);
    
            if ($accountingPeriod) {
                $query->whereHas('projectRevenues', function($q) use ($accountingPeriod) {
                    $q->whereBetween('revenue_year_month', [$accountingPeriod->period_start_at, $accountingPeriod->period_end_at]);
                });
            }
        }
    
    }

    // 関連する会計期間内の売上合計を取得する
    public function getTotalPeriodRevenueAttribute()
    {
        // デバッグ用：関連付けられた会計期間の開始日と終了日をログに出力する
        Log::debug('関連付けられた会計期間の開始日: ' . $this->accountingPeriodStart);
        Log::debug('関連付けられた会計期間の終了日: ' . $this->accountingPeriodEnd);

        // 関連付けられた会計期間が存在しない場合は、0を返す
        if (is_null($this->accountingPeriodStart) || is_null($this->accountingPeriodEnd)) {
            return 0;
        }

        // 関連する会計期間内の売上合計を取得する
        return $this->projectRevenues()
            ->whereBetween('revenue_year_month', [$this->accountingPeriodStart, $this->accountingPeriodEnd])
            ->sum('revenue');
    }

    // accounting_periodの開始日と終了日をセットするメソッド
    public function setAccountingPeriodDates($accountingPeriodStart, $accountingPeriodEnd)
    {
        $this->accountingPeriodStart = $accountingPeriodStart;
        $this->accountingPeriodEnd = $accountingPeriodEnd;
    }

    public function getTotalAllRevenueAttribute()
    {
        $totalRevenue = $this->projectRevenues()->sum('revenue');

        return $totalRevenue;
    }



    // リレーション
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function distributionType()
    {
        return $this->belongsTo(DistributionType::class);
    }
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }
    public function accountingType()
    {
        return $this->belongsTo(AccountingType::class);
    }
    public function salesStage()
    {
        return $this->belongsTo(SalesStage::class);
    }
    public function accountingPeriods()
    {
        return $this->hasmany(AccountingPeriod::class);
    }
    public function accountAffiliation1()
    {
        return $this->belongsTo(Affiliation1::class, 'account_affiliation1_id');
    }
    public function accountAffiliation2()
    {
        return $this->belongsTo(Affiliation2::class, 'account_affiliation2_id');
    }
    public function accountAffiliation3()
    {
        return $this->belongsTo(Affiliation3::class, 'account_affiliation3_id');
    }
    public function accountUser()
    {
        return $this->belongsTo(User::class);
    }
    public function projectRevenues()
    {
        return $this->hasmany(ProjectRevenue::class);
    }
    public function billingCorporation()
    {
        return $this->belongsTo(Corporation::class, 'billing_corporation_id');
    }
    public function keepfiles()
    {
        return $this->hasMany(Keepfile::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}