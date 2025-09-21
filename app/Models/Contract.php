<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;
use Illuminate\Support\Str;//add
use Kyslik\ColumnSortable\Sortable;

class Contract extends Model
{
    use HasFactory, Sortable;


    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
    }



    public static function generateContractNumber($clientId)
    {
        $lastContractNum = Contract::where('client_id', $clientId)
                            ->orderBy('contract_num', 'desc')
                            ->first();

        if ($lastContractNum) {
            $lastSerialNumber = $lastContractNum->contract_num;
            $newSerialNumber = str_pad($lastSerialNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newSerialNumber = '001';
        }

        return "$newSerialNumber";
    }

    // リレーション定義
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function contractDetails()
    {
        return $this->hasMany(ContractDetail::class);
    }
    public function contractType()
    {
        return $this->belongsTo(ContractType::class);
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }


    // public function contractChangeType()
    // {
    //     return $this->belongsTo(ContractChangeType::class);
    // }
    // public function contractUpdateType()
    // {
    //     return $this->belongsTo(ContractUpdateType::class);
    // }
    // public function contractPartnerType()
    // {
    //     return $this->belongsTo(ContractPartnerType::class);
    // }
    // public function contractsheetStatus()
    // {
    //     return $this->belongsTo(ContractsheetStatus::class);
    // }






    // 最新の契約詳細を取得（契約開始日が最も新しいもの）
    public function latestContractDetail()
    {
        return $this->hasOne(ContractDetail::class)->latest('contract_start_at');
    }

    // 最初の契約詳細を取得（契約開始日が最も古いもの）
    public function firstContractDetail()
    {
        return $this->hasOne(ContractDetail::class)->oldest('contract_start_at');
    }

    // アクセサ：有効フラグ（親で解約日が入ってたら解約、空欄なら有効）
    public function getIsActiveAttribute()
    {
        return is_null($this->cancelled_at) ? '有効' : '解約';
    }

    // アクセサ：契約未更新フラグ（子の一番新しい契約日の次回契約更新日とシステム日付の比較）
    public function getIsUpdateOverdueAttribute()
    {
        $latestDetail = $this->latestContractDetail;
        if (!$latestDetail) return '-';
        
        return $latestDetail->contract_end_at < now() ? '未更新' : '-';
    }

    // アクセサ：初回契約日（子の一番契約日が古い値）
    public function getFirstContractDateAttribute()
    {
        return $this->firstContractDetail?->contract_start_at;
    }

    // アクセサ：次回契約更新日（子の一番契約日が新しい値）
    public function getNextUpdateDateAttribute()
    {
        return $this->latestContractDetail?->contract_end_at;
    }

    // アクセサ：現契約金額（子の一番契約日が新しい値）
    public function getCurrentContractAmountAttribute()
    {
        return $this->latestContractDetail?->contract_amount ?? 0;
    }

    // アクセサ：契約先区分（子の一番契約日が新しい値）
    public function getCurrentContractPartnerTypeAttribute()
    {
        return $this->latestContractDetail?->contractPartnerType?->contract_partner_type_name ?? '-';
    }

    // アクセサ：自動更新区分（子の一番契約日が新しい値）
    public function getCurrentAutoUpdateTypeAttribute()
    {
        return $this->latestContractDetail?->contractUpdateType?->contract_update_type_name ?? '-';
    }
}
