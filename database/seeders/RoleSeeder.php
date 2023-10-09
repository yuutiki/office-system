<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'role_num' => '10',
            'role_name' => 'システム管理者',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Role::create([
            'role_num' => '20',
            'role_name' => '管理者',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Role::create([
            'role_num' => '30',
            'role_name' => 'マネージャ',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Role::create([
            'role_num' => '40',
            'role_name' => 'メンバー',
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
