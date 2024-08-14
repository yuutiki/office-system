<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use App\Observers\GlobalObserver;


class EstimateAttachment extends Model
{
    use HasFactory, HasUlids;

    protected $keyType = 'ulid'; // 主キーの型をulidに設定
    protected $primaryKey = 'ulid'; // 主キー名をulidに設定
    public $incrementing = false; // 自動インクリメントを無効化

    protected $fillable = [
        'estimate_id',
        'file_name',
        'file_size',
    ];

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
    }

    public function estimate()
    {
        return $this->belongsTo(Estimate::class, 'estimate_id', 'ulid');
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
