<?php

namespace Database\Seeders;

use App\Models\PasswordPolicy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PasswordPolicySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        PasswordPolicy::create([
            'min_length' => '8',
            'require_uppercase' => '1',
            'require_lowercase' => '1',
            'require_numeric' => '1',
            'require_symbol' => '1',
            'banned_email_use' => '1',
            'banned_password_reuse' => '1',
            'max_login_attempt' => '5',
            'lockout_time' => '60',
            'date_password_expiration' => '180',
            'date_inactive' => '30',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}