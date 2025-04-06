<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserColumnSetting extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'page_identifier', 'visible_columns'];
    protected $casts = [
        'visible_columns' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
