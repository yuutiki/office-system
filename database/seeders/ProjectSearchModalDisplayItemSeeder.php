<?php

namespace Database\Seeders;

use App\Models\ProjectSearchModalDisplayItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSearchModalDisplayItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 初期データを投入
        ProjectSearchModalDisplayItem::insert([
            [
                'screen_id' => 'keepfile_create',
                'column_key' => 'project_num',
                'display_default_name' => 'プロジェクト№',
                'display_name' => 'プロジェクト№',
                'display_order' => 1,
                'is_visible' => true,
            ],
            [
                'screen_id' => 'keepfile_create',
                'column_key' => 'project_name',
                'display_default_name' => 'プロジェクト名',
                'display_name' => 'プロジェクト名',
                'display_order' => 2,
                'is_visible' => true,
            ],
            [
                'screen_id' => 'keepfile_create',
                'column_key' => 'sales_stage.sales_stage_name',
                'display_default_name' => '営業段階',
                'display_name' => '営業段階',
                'display_order' => 3,
                'is_visible' => true,
            ],
            [
                'screen_id' => 'keepfile_create',
                'column_key' => 'account_user.user_name',
                'display_default_name' => '営業担当',
                'display_name' => '営業担当',
                'display_order' => 4,
                'is_visible' => true,
            ],
        ]);
    }
}
