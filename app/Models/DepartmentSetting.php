<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'max_level',
        'code_length',
    ];

    /**
     * システムで利用する唯一の設定を取得
     */
    public static function getSettings(): self
    {
        return self::firstOrFail();
    }
}
