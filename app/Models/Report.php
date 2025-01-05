<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add
use App\Observers\GlobalObserver;
use Illuminate\Notifications\Notification;

class Report extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'client_id',
        'report_type_id',
        'contact_at',
        'contact_type_id',
        'report_title',
        'report_content',
        'report_notice',
        'is_draft',
    ];

    // 型変換の定義
    protected $casts = [
        'is_draft' => 'boolean',
    ];

    public static $rulesEdit = [
        'report_title' => 'required|max:255',
        'report_content' => 'required',
    ];

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
    }

    // アクセス制御の定義
    protected static function booted()
    {
        // 下書きは作成者のみが閲覧可能
        static::addGlobalScope('accessControl', function ($query) {
            if (auth()->check()) {
                $query->where(function ($q) {
                    $q->where('is_draft', false)
                      ->orWhere(function ($q) {
                          $q->where('is_draft', true)
                               ->where('user_id', auth()->id());
                      });
                });
            }
        });
    }











    // 中間テーブルreport_to_recipientsを介して報告内容が報告先（受信者）と関連するリレーションok
    public function recipients()
    {
        return $this->belongsToMany(User::class, 'report_to_recipients', 'report_id', 'recipient_id')
            ->withPivot('is_read')// pivotテーブルのreadカラムを取得する
            ->withTimestamps();
    }

    // 報告に関連するコメントのリレーションok
    public function comments()
    {
        return $this->hasMany(Comment::class, 'report_id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function reportType()
    {
        return $this->belongsTo(ReportType::class);
    }
    public function contactType()
    {
        return $this->belongsTo(ContactType::class);
    }
    // 報告に関連する報告者（投稿者）のリレーションok
    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
