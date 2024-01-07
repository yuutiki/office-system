<?php

namespace Database\Seeders;

use App\Models\ReportType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportTypeSeeder extends Seeder
{
    public function run(): void
    {
        reportType::create([
            'report_type_code' => '10',
            'report_type_name' => '営業活動報告',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        reportType::create([
            'report_type_code' => '20',
            'report_type_name' => '受注報告',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        reportType::create([
            'report_type_code' => '30',
            'report_type_name' => '失注報告',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        reportType::create([
            'report_type_code' => '40',
            'report_type_name' => '解約報告',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
    }
}
