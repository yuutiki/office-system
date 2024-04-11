<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add
use Illuminate\Support\Str;
use App\Observers\GlobalObserver;



class Project extends Model
{
    use HasFactory,Sortable;

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
}
