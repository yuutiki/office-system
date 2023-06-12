<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => '末久 優(admin)',
            'email' => 'admin@gmail.com',
            'password' => \Hash::make('admin@gmail.com'),
            'employee_id' => '000386',
            'name_kana' => 'スエヒサ ユウ',
            'role_id' => 1,
            'employee_status_id'=> 1
        ]);
    }
}
