<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;
use Illuminate\Support\Str;//add


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
