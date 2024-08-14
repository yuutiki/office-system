<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Support\Str;

class Estimate extends Model
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
        'project_id', 'estimate_num', 'estimate_title', 'estimate_at', 'submit_at',
        'subtotal_amount', 'tax_amount', 'total_amount', 'delivery_place',
        'delivery_at', 'transaction_method', 'expiration_at', 'estimate_memo',
        'estimate_sheet', 'approval_info', 'supervisor_comment_1',
        'supervisor_comment_2', 'created_by', 'updated_by'
    ];

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($model) {
    //         $model->ulid = (string) Str::ulid();
    //     });
    // }

    public static function generateEstimateNumber($projectId)
    {
        $projectNum = Project::where('id', $projectId)
                        ->first()->project_num;

        $lastEstimateNum = Estimate::where('project_id', $projectId)
                            ->orderBy('estimate_num', 'desc')
                            ->first();
                            

        if ($lastEstimateNum) {
            $lastSerialNumber =  (int) Str::substr($lastEstimateNum->estimate_num, -3);
            $newSerialNumber = str_pad($lastSerialNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newSerialNumber = '001';
        }

        return "$projectNum-$newSerialNumber";
    }

    public function details()
    {
        return $this->hasMany(EstimateDetail::class, 'estimate_id', 'ulid');
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
