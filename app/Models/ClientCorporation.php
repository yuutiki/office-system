<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add
use Illuminate\Support\Facades\DB;//add


class ClientCorporation extends Model
{
    use HasFactory;
    use Sortable;//add

    protected $fillable = [
        'clientcorporation_num',
        'clientcorporation_name',
        'clientcorporation_kana_name',
        'clientcorporation_abbreviation_name',
    ];

    public $sortable = [
        'clientcorporation_num',
        'clientcorporation_name',
        'clientcorporation_kana_name'
    ];

    public function storeWithTransaction($data)//法人番号自動採番ロジック
    {
        //DB::transactionメソッドを使用してトランザクションを開始
        return DB::transaction(function () use ($data)
        {
            //本メソッド内で法人情報を作成し、法人番号を採番
            $lastCorporation = ClientCorporation::orderBy('id', 'desc')->first();
            $lastNumber = $lastCorporation ? $lastCorporation->clientcorporation_num : '000000';
            $newNumber = str_pad((int) $lastNumber + 1, 6, '0', STR_PAD_LEFT);

            $data['clientcorporation_num'] = $newNumber;
            $corporation = ClientCorporation::create($data);

            if ($corporation)
            {
                return true;
            }
            else
            {
                return false;
            }
        });
    }

    //GrobalObserverを利用して登録する
    public function getCreatedByColumn()
    {
        return 'created_by';
    }

    public function getUpdatedByColumn()
    {
        return 'updated_by';
    }

    // 法人正式名称のsetter（Mutator）を定義
    public function setClientcorporationNameAttribute($value)
    {
        // 全角スペースを半角スペースに変換して設定
        $this->attributes['clientcorporation_name'] = mb_convert_kana($value, 's');
    }

    // 法人正式カナ名称のsetter（Mutator）を定義
    public function setClientcorporationKanaNameAttribute($value)
    {
        // 全角スペースを半角スペースに変換して設定
        $this->attributes['clientcorporation_kana_name'] = mb_convert_kana($value, 'KVs');
    }
    
    public function clients()//relation
    {
        return $this->hasMany(Client::class);
    }
}
