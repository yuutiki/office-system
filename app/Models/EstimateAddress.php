<?php

namespace App\Models;

use App\Observers\GlobalObserver;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateAddress extends Model
{
    use HasFactory, HasUlids;

    protected $keyType = 'ulid'; // 主キーの型をulidに設定
    protected $primaryKey = 'ulid'; // 主キー名をulidに設定
    public $incrementing = false; // 自動インクリメントを無効化

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
    }

    protected $fillable = [

        'estimate_address_code',
        'estimate_address_name',
        'estimate_address_1',
        'estimate_address_2',
        'estimate_address_3',
        'estimate_address_tel',
        'estimate_address_fax',
        'estimate_address_mail',
        'estimate_address_url',
        'project_affiliation1',
        'project_affiliation2',
        'project_affiliation3',
        'project_department_id',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function estimates()
    {
        return $this->hasMany(Estimate::class);
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'project_department_id', 'id');
    }
}
