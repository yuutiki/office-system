<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Department;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->bothify('DEP###')),
            'name' => $this->faker->company(),
            'name_kana' => $this->faker->kanaName(),
            'name_en' => $this->faker->companySuffix(),
            'name_short' => $this->faker->word(),
            'parent_id' => null,
            'level' => 1,
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }

    /**
     * 子部門（階層2以上）を生成するステート
     */
    public function child(?Department $parent = null): Factory
    {
        return $this->state(function () use ($parent) {
            $parent = $parent ?? Department::factory()->create();

            return [
                'parent_id' => $parent->id,
                'level' => $parent->level + 1,
            ];
        });
    }
}
