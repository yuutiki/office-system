<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeeStatus;

class EmployeeStatusSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        EmployeeStatus::create([
            'employee_status_num' => '10',
            'employee_status_name' => '在職',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        EmployeeStatus::create([
            'employee_status_num' => '90',
            'employee_status_name' => '退職',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}