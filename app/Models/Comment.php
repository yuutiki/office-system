<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable =[
        'content',
        'report_id',
        'user_id'
    ];

    public static $rules = [
        'content' => 'required',
    ];
    
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
