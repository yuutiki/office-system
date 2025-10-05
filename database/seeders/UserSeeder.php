<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'user_num' => '999999',
            'user_name' => 'システム管理者',
            'user_kana_name' => 'システムカンリシャ',
            'birth' => '1997-04-23',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('gPpefPCGU3Md5'),
            'int_phone' => '415',
            'ext_phone' => '070-2307-7176',
            'is_enabled' => 1,
            'employee_status_id'=> 1,
            // 'affiliation1_id'=> 1,
            // 'affiliation2_id'=> 1,
            'department_id'=> 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'role' => config('sytemadmin.system_admin'),
        ]);
        User::create([
            'user_num' => '000386',
            'user_name' => '末久 優(admin)',
            'user_kana_name' => 'スエヒサ ユウ',
            'birth' => '1997-04-23',
            'email' => 'suehisa@gmail.com',
            'password' => Hash::make('gPpefPCGU3Md5'),
            'int_phone' => '415',
            'ext_phone' => '070-2307-7176',
            'is_enabled' => 1,
            'employee_status_id'=> 1,
            // 'affiliation1_id'=> 1,
            // 'affiliation2_id'=> 1,
            'department_id'=> 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        User::create([
            'user_num' => '999998',
            'user_name' => '小髙 秀元',
            'user_kana_name' => 'オダカ ヒデユキ',
            'birth' => '1997-04-23',
            'email' => 'odaka@example.com',
            'password' => Hash::make('uohuJHa|a7'),
            'int_phone' => '415',
            'ext_phone' => '090-1234-5678',
            'is_enabled' => 1,
            'employee_status_id'=> 1,
            // 'affiliation1_id'=> 1,
            // 'affiliation2_id'=> 1,
            'department_id'=> 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 追加で98人のユーザーを作成（合計100人になるように）
        // User::factory()->count(98)->create();
    }
}