<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee_status;

class EmployeeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee_status::create([
            'employee_status_num' => '10',
            'employee_status_name' => '在職',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Employee_status::create([
            'employee_status_num' => '90',
            'employee_status_name' => '退職',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
