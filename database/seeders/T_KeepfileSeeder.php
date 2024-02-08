<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Keepfile;

class T_KeepfileSeeder extends Seeder
{
    public function run(): void
    {
        Keepfile::create([
            'project_num' => '1494-01-28-00',
            'clientname' => '札幌大谷学園',
            'purpose' => 'バージョンアップ',
            'keep_at' => '2024-02-06',
            'return_at' => '2024-10-31',
            'memo' => 'USB取得',
            'is_finished' => '0',
            'user_id' => '1'
        ]);

        Keepfile::create([
            'project_num' => '9999-01-99-00',
            'clientname' => '東洋女子高等学校',
            'purpose' => 'バージョンアップ（Cloud移行）',
            'keep_at' => '2024-02-05',
            'return_at' => '2024-08-31',
            'memo' => '貴社データ共有サービス',
            'is_finished' => '0',
            'user_id' => '1'
        ]);

        Keepfile::create([
            'project_num' => '9999-99-99-02',
            'clientname' => '烏丸大学',
            'purpose' => 'バージョンアップ',
            'keep_at' => '2023-03-01',
            'return_at' => '2024-03-31',
            'memo' => 'テスト',
            'is_finished' => '0',
            'user_id' => '1'
        ]);

        Keepfile::create([
            'project_num' => '9999-99-99-03',
            'clientname' => '烏丸大学',
            'purpose' => 'バージョンアップ',
            'keep_at' => '2023-03-01',
            'return_at' => '2024-03-31',
            'memo' => 'テスト',
            'is_finished' => '0',
            'user_id' => '1'
        ]);

        Keepfile::create([
            'project_num' => '9999-99-99-04',
            'clientname' => '烏丸大学',
            'purpose' => 'バージョンアップ',
            'keep_at' => '2023-03-01',
            'return_at' => '2024-03-31',
            'memo' => 'テスト',
            'is_finished' => '0',
            'user_id' => '1'
        ]);

        Keepfile::create([
            'project_num' => '9999-99-99-05',
            'clientname' => '烏丸大学',
            'purpose' => 'バージョンアップ',
            'keep_at' => '2023-03-01',
            'return_at' => '2024-03-31',
            'memo' => 'テスト',
            'is_finished' => '0',
            'user_id' => '1'
        ]);

        Keepfile::create([
            'project_num' => '9999-99-99-06',
            'clientname' => '烏丸大学',
            'purpose' => 'バージョンアップ',
            'keep_at' => '2023-03-01',
            'return_at' => '2024-03-31',
            'memo' => 'テスト',
            'is_finished' => '0',
            'user_id' => '1'
        ]);

        Keepfile::create([
            'project_num' => '9999-99-99-07',
            'clientname' => '烏丸大学',
            'purpose' => 'バージョンアップ',
            'keep_at' => '2023-03-01',
            'return_at' => '2024-03-31',
            'memo' => 'テスト',
            'is_finished' => '0',
            'user_id' => '1'
        ]);

        Keepfile::create([
            'project_num' => '9999-99-99-08',
            'clientname' => '烏丸大学',
            'purpose' => 'バージョンアップ',
            'keep_at' => '2023-03-01',
            'return_at' => '2024-03-31',
            'memo' => 'テスト',
            'is_finished' => '0',
            'user_id' => '1'
        ]);
    }
}
