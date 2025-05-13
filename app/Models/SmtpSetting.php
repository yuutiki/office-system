<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmtpSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'from_address',
        'from_name',
        'type',
        'is_active',
        'auth_type',
        'oauth_client_id',
        'oauth_client_secret',
        'oauth_refresh_token',
        'oauth_access_token',
        'oauth_expires_at',
    ];
    
    protected $casts = [
        'oauth_expires_at' => 'datetime',
    ];
    
    /**
     * OAuth認証が必要かどうか
     */
    public function requiresOAuth()
    {
        return $this->auth_type === 'oauth';
    }
    
    /**
     * OAuth認証が設定済みかどうか
     */
    public function hasOAuthTokens()
    {
        return $this->oauth_refresh_token && $this->oauth_access_token;
    }
}
