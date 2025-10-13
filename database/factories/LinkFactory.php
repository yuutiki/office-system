<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Link;
use App\Models\Department;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    protected $model = Link::class;

    public function definition(): array
    {
        return [
            'display_name' => $this->faker->words(2, true),
            'display_order' => $this->faker->numberBetween(1, 50),
            'url' => $this->faker->url(),
            'department_id' => Department::factory(),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
