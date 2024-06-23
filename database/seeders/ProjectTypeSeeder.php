<?php

namespace Database\Seeders;

use App\Models\ProjectType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        ProjectType::create([
            'project_type_code' => '10',
            'project_type_name' => 'フロー',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProjectType::create([
            'project_type_code' => '20',
            'project_type_name' => 'ストック（サポート）',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProjectType::create([
            'project_type_code' => '30',
            'project_type_name' => 'ストック（クラウド）',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProjectType::create([
            'project_type_code' => '40',
            'project_type_name' => 'ストック（その他）',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}