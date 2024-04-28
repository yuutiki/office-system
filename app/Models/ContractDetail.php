<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;

class ContractDetail extends Model
{
    use HasFactory;

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
    }


        // 期間を取得する関数
        public function getPeriodUntilNowAttribute()
        {
            // firstContractStartAt が存在しない場合は空文字を返す
            if (!$this->firstContractStartAt) {
                return '';
            }
    
            // Contract に紐づく最新の契約詳細を取得
            $contract = $this->contract;
            $latestContractDetail = $contract->contractDetails()->latest()->first();
    
            // 解約日がセットされている場合は解約日までの期間を計算
            if ($contract->contract_end_at) {
                $startDate = $latestContractDetail->firstContractStartAt;
                $endDate = $contract->contract_end_at;
                $period = $startDate->diff($endDate);
    
                // 期間を年、月、日単位で表示
                $years = $period->y;
                $months = $period->m;
                $days = $period->d;
    
                return "{$years}年{$months}ヶ月{$days}日";
            }
    
            // 解約日がセットされていない場合は現在日付までの期間を計算
            $startDate = $latestContractDetail->firstContractStartAt;
            $endDate = now(); // 現在日付
            $period = $startDate->diff($endDate);
    
            // 期間を年、月、日単位で表示
            $years = $period->y;
            $months = $period->m;
            $days = $period->d;
    
            return "{$years}年{$months}ヶ月{$days}日";
        }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function contractUpdateType()
    {
        return $this->belongsTo(ContractUpdateType::class);
    }

    public function contractChangeType()
    {
        return $this->belongsTo(ContractChangeType::class);
    }

    public function contractPartnerType()
    {
        return $this->belongsTo(ContractPartnerType::class);
    }

    public function contractSheetStatus()
    {
        return $this->belongsTo(ContractSheetStatus::class);
    }
    public function attachments()
    {
        return $this->hasMany(ContractDetailAttachment::class);
    }
}
