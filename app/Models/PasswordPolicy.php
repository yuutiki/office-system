<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'min_length',
        'require_uppercase',
        'require_lowercase',
        'require_numeric',
        'require_symbol',
        'banned_email_use',
        'banned_password_reuse',
        'max_login_attempt',
        'lockout_time',
        'date_password_expiration',
        'date_inactive',
        'created_by',
        'updated_by',
    ];

    // max_login_attempt のアクセサを定義
    public function getMaxLoginAttemptAttribute(): int
    {
        return $this->attributes['max_login_attempt'] ?? 5; // デフォルト値は5
    }
}
