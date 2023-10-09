<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'employee_num' => '000386',
            'name' => '末久 優(admin)',
            'kana_name' => 'スエヒサ ユウ',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@gmail.com'),
            'int_phone' => '415',
            'ext_phone' => '070-2307-7176',
            'is_enabled' => 1,
            'role_id' => 1,
            'employee_status_id'=> 1,
            'company_id'=> 1,
            'department_id'=> 2,
            'division_id'=> 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
