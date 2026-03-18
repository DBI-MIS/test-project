<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
        'name' => fake()->sentence(1),
        'number' => fake()->randomNumber(9, true),
        'description' => fake()->paragraph(),
        'created_by' => 1,
        'task_type_id' => fake()->randomElement([1, 2, 3]),
        ];
    }
}
