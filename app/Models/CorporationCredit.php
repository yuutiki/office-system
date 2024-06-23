<?php

namespace App\Models;

use App\Observers\GlobalObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class CorporationCredit extends Model
{
    use HasFactory, HasUlids;

    protected $keyType = 'ulid'; // 主キーの型をulidに設定
    protected $primaryKey = 'ulid'; // 主キー名をulidに設定
    public $incrementing = false; // 自動インクリメントを無効化

    protected $fillable = [
        'corporation_id',
        'credit_limit',
        'credit_rate',
        'credit_rater',
        'credit_reason',
        'created_by',
        'updated_by'
    ];

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();

        self::observe(GlobalObserver::class);
    }

    public function corporation()
    {
        return $this->belongsTo(Corporation::class, 'corporation_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
