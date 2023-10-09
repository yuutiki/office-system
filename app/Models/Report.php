<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add

class Report extends Model
{
    use HasFactory;
    use Sortable;//add

    public static $rulesEdit = [
        'title' => 'required|max:255',
        'content' => 'required',
    ];

    // 報告に関連する報告者（投稿者）のリレーションok
    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
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
}
