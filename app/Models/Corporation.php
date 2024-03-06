<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add
use Illuminate\Support\Facades\DB;//add
use App\Observers\GlobalObserver;


class Corporation extends Model
{
    use HasFactory;
    use Sortable;//add

    protected $fillable = [
        'corporation_num',
        'corporation_name',
        'corporation_kana_name',
        'corporation_short_name',
        'credit_limit',
        'memo',
        'created_by',
        'updated_by',
    ];

    public $sortable = [
        'corporation_num',
        'corporation_name',
        'corporation_kana_name'
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
        if (isset($filters['corporation_num'])) {
            $query->where('corporation_num', 'like', '%' . $filters['corporation_num'] . '%');
        }

        // if (isset($filters['corporation_name'])) {
        //     $spaceConversion = mb_convert_kana($filters['corporation_name'], 's'); //全角スペース⇒半角スペースへ変換
        //     $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
    
        //     $query->where(function($query) use ($wordArraySearched) {
        //         foreach ($wordArraySearched as $value) {
        //             $query->orWhere('corporation_name', 'like', '%' . $value . '%');
        //             $query->orWhere('corporation_kana_name', 'like', '%' . $value . '%');
        //         }
        //     });
        // }

        if (isset($filters['corporation_name'])) {
            $spaceConversion = mb_convert_kana($filters['corporation_name'], 's'); //全角スペース⇒半角スペースへ変換
            // $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
    
            $query->orWhere('corporation_name', 'like', '%' . $spaceConversion . '%');
            $query->orWhere('corporation_kana_name', 'like', '%' . $spaceConversion . '%');
        }
    }

    public static function storeWithTransaction(array $data)
    {
        return DB::transaction(function () use ($data) {
            // ロックをかけて最後の法人情報を取得
            $lastCorporation = Corporation::lockForUpdate()->orderBy('id', 'desc')->first();
            $lastNumber = $lastCorporation ? $lastCorporation->corporation_num : '000000';
            
            // 最後の番号をインクリメントして新しい番号を生成
            $newNumber = str_pad((int) $lastNumber + 1, 6, '0', STR_PAD_LEFT);
            
            $data['corporation_num'] = $newNumber;
    
            // データ登録
            $corporation = Corporation::create($data);
    
            return $corporation;
        });
    }





    

    // 法人正式名称のsetter（Mutator）を定義
    public function setCorporationNameAttribute($value)
    {
        // 全角スペースを半角スペースに変換して設定
        $this->attributes['corporation_name'] = mb_convert_kana($value, 's');
    }

    // 法人正式カナ名称のsetter（Mutator）を定義
    public function setCorporationKanaNameAttribute($value)
    {
        // 全角スペースを半角スペースに変換して設定
        $this->attributes['corporation_kana_name'] = mb_convert_kana($value, 'KVs');
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
