<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;

class Contract extends Model
{
    use HasFactory;


    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function contractType()
    {
        return $this->belongsTo(ContractType::class);
    }
    public function contractChangeType()
    {
        return $this->belongsTo(ContractChangeType::class);
    }
    public function contractUpdateType()
    {
        return $this->belongsTo(ContractUpdateType::class);
    }
    public function contractPartnerType()
    {
        return $this->belongsTo(ContractPartnerType::class);
    }
    public function contractsheetStatus()
    {
        return $this->belongsTo(ContractsheetStatus::class);
    }
}
