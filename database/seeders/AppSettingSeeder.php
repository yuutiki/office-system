<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        AppSetting::create([
            'setting_code' => '100',
            'setting_name' => '所属部門設定',
            'setting_name_en' => 'Department Setttings',
            'description' => 'システムで利用する所属の階層を１～５階層までで設定できます。途中で変更したとしても過去のデータは保持し続けます。',
            'is_editable' => 1,
            'route' => 'department-settings.edit',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppSetting::create([
            'setting_code' => '200',
            'setting_name' => '送信元SMTP情報設定',
            'setting_name_en' => 'SMTP Sender Settings',
            'description' => '本システムからメールを送信する場合に経由するSMTP情報です',
            'is_editable' => 1,
            'route' => 'smtp-settings.index',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppSetting::create([
            'setting_code' => '900',
            'setting_name' => 'パスワードポリシー設定',
            'setting_name_en' => 'Password Policy Settings',
            'description' => '利用ユーザーがパスワードを設定するときのルールを設定できます。',
            'is_editable' => 1,
            'route' => 'password-policy.edit',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
