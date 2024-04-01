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
            'project_id' => '1',
            // 'client_name' => '札幌大谷学園',
            'purpose' => 'バージョンアップ',
            'keep_at' => '2024-02-06',
            'return_at' => '2024-10-31',
            'keepfile_memo' => '1494-01-28-00：USB取得',
            'is_finished' => '0',
            'user_id' => '2'
        ]);

        Keepfile::create([
            'project_id' => '2',
            // 'client_name' => '東洋女子高等学校',
            'purpose' => 'バージョンアップ（Cloud移行）',
            'keep_at' => '2024-02-05',
            'return_at' => '2024-08-31',
            'keepfile_memo' => '貴社データ共有サービス',
            'is_finished' => '0',
            'user_id' => '2'
        ]);

        Keepfile::create([
            'project_id' => '3',
            // 'client_name' => '聖路加国際大学',
            'purpose' => 'シラバス不具合調査',
            'keep_at' => '2024-03-04',
            'return_at' => '2024-06-30',
            'keepfile_memo' => 'リモート取得',
            'is_finished' => '0',
            'user_id' => '2'
        ]);

        Keepfile::create([
            'project_id' => '4',
            // 'client_name' => '桐朋学園大学',
            'purpose' => 'Web学生カルテ導入',
            'keep_at' => '2023-03-06',
            'return_at' => '2024-06-30',
            'keepfile_memo' => 'リモート取得',
            'is_finished' => '0',
            'user_id' => '2'
        ]);

        // Keepfile::create([
        //     'project_num' => '101222-C-C01-0004',
        //     'client_name' => '烏丸大学',
        //     'purpose' => 'バージョンアップ',
        //     'keep_at' => '2023-03-01',
        //     'return_at' => '2024-03-31',
        //     'keepfile_memo' => 'テスト',
        //     'is_finished' => '0',
        //     'user_id' => '2'
        // ]);
    }
}
