<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add
use Illuminate\Support\Facades\DB;//add
use App\Observers\GlobalObserver;


class ClientCorporation extends Model
{
    use HasFactory;
    use Sortable;//add

    protected $fillable = [
        'clientcorporation_num',
        'clientcorporation_name',
        'clientcorporation_kana_name',
        'clientcorporation_short_name',
        'credit_limit',
        'memo',
        'created_by',
        'updated_by',
    ];

    public $sortable = [
        'clientcorporation_num',
        'clientcorporation_name',
        'clientcorporation_kana_name'
    ];

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();

        self::observe(GlobalObserver::class);
    }

    // index画面の検索ロジック
    public function scopeFilter($query, $filters)
    {
        if (isset($filters['clientcorporation_num'])) {
            $query->where('clientcorporation_num', 'like', $filters['clientcorporation_num'] . '%');
        }

        if (isset($filters['clientcorporation_name'])) {
            $spaceConversion = mb_convert_kana($filters['clientcorporation_name'], 's'); //全角スペース⇒半角スペースへ変換
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
    
            $query->where(function($query) use ($wordArraySearched) {
                foreach ($wordArraySearched as $value) {
                    $query->orWhere('clientcorporation_name', 'like', '%' . $value . '%');
                    $query->orWhere('clientcorporation_kana_name', 'like', '%' . $value . '%');
                }
            });
        }
    }

    public static function storeWithTransaction(array $data)
    {
        return DB::transaction(function () use ($data) {
            // ロックをかけて最後の法人情報を取得
            $lastCorporation = ClientCorporation::lockForUpdate()->orderBy('id', 'desc')->first();
            $lastNumber = $lastCorporation ? $lastCorporation->clientcorporation_num : '000000';
            $newNumber = str_pad((int) $lastNumber + 1, 6, '0', STR_PAD_LEFT);

            $data['clientcorporation_num'] = $newNumber;

            // データ登録
            $corporation = ClientCorporation::create($data);

            return $corporation;
        });
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
    

    // 以下リレーション設定
    public function clients()
    {
        return $this->hasMany(Client::class);
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
