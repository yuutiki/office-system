<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Department; // ← 追加
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'user_num' => $this->generateUniqueUserNum(),
            'user_name' => $this->faker->name(),
            'user_kana_name' => $this->faker->kanaName(),
            'birth' => $this->faker->date('Y-m-d', '-20 years'),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'int_phone' => $this->faker->numberBetween(100, 999),
            'ext_phone' => $this->faker->phoneNumber(),
            'is_enabled' => $this->faker->boolean(90),
            'employee_status_id' => $this->faker->numberBetween(1, 2),
            'affiliation1_id' => $this->faker->numberBetween(1, 1),
            'affiliation2_id' => $this->faker->numberBetween(1, 6),

            // ✅ 部門はDepartmentFactoryを使って関連付ける
            'department_id' => Department::factory(),

            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),

            'profile_image' => 'users/profile_image/default.png',
            'password_change_required' => false,

            'role' => $this->faker->randomElement([
                config('sytemadmin.system_admin') ?? 'system_admin', // ← config呼び出しに保険
                'user',
            ]),
        ];
    }

    protected function generateUniqueUserNum()
    {
        do {
            $userNum = str_pad($this->faker->numberBetween(1, 999997), 6, '0', STR_PAD_LEFT);
        } while (User::where('user_num', $userNum)->exists());

        return $userNum;
    }
}
