<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(EmployeeStatusSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(T_KeepfileSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(InstallationTypeSeeder::class);
        $this->call(TradeStatusSeeder::class);
        $this->call(ClientTypeSeeder::class);
        $this->call(PrefectureSeeder::class);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
