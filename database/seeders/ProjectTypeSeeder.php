<?php

namespace Database\Seeders;

use App\Models\ProjectType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectTypeSeeder extends Seeder
{
    public function run(): void
    {
        ProjectType::create([
            'project_type_code' => '10',
            'project_type_name' => '通常',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProjectType::create([
            'project_type_code' => '20',
            'project_type_name' => '継続',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
