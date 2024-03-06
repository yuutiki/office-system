<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;

class Comment extends Model
{
    use HasFactory;

    protected $fillable =[
        'content',
        'report_id',
        'user_id',
        'created_by',
        'updated_by',
    ];

    public static $rules = [
        'content' => 'required',
    ];

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
    }
    
    // コメントに関連する報告のリレーションok
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    // コメントに関連するユーザのリレーションok
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
