<?php

namespace Database\Seeders;

use App\Models\SmtpSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class T_SmtpSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // OAuth認証 + TLS暗号化（Gmail OAuth）
        SmtpSetting::create([
            'name' => 'Gmail OAuth',
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'encryption' => 'tls',
            'auth_type' => 'oauth',
            'username' => 'user@gmail.com',
            'oauth_client_id' => 'client-id',
            'oauth_client_secret' => 'client-secret',
            // 'oauth_expires_at' => '',
            'from_address' => 'test@gmail.com',
            'from_name' => 'testuser',
            'type' => 'internal',
        ]);

        // パスワード認証 + 暗号化なし（内部SMTPサーバー等）
        SmtpSetting::create([
            'name' => '社内SMTPサーバー',
            'host' => 'internal-smtp.company.local',
            'port' => 25,
            'encryption' => 'none',
            'auth_type' => 'password',
            'username' => 'user',
            'password' => 'password',
            'from_address' => 'test@gmail.com',
            'from_name' => 'testuser',
            'type' => 'external',
        ]);
    }
}