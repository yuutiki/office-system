<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'permission_code' => '00',
            'permission_name' => '権限なし',
            'description' => '権限なし',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Permission::create([
            'permission_code' => '10',
            'permission_name' => '参照のみ',
            'description' => '参照が可能',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Permission::create([
            'permission_code' => '20',
            'permission_name' => '参照＋追加更新',
            'description' => '参照＋追加更新のみ可能',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Permission::create([
            'permission_code' => '30',
            'permission_name' => '参照＋追加更新＋削除',
            'description' => '参照＋追加更新＋削除が可能',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Permission::create([
            'permission_code' => '50',
            'permission_name' => '参照＋追加更新＋削除＋書出',
            'description' => '参照＋追加更新＋削除＋書出が可能',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Permission::create([
            'permission_code' => '50',
            'permission_name' => '全権限',
            'description' => '参照＋追加更新＋削除＋一括操作が可能',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}