<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
        $status = $this->faker->randomElement([0, 1, 2]);
        return [
            'project_id' => Project::all()->random()->id,
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(1),
            'status' => $status,
            'start_date' => now(),
            'end_date'=> now()->addDays(7),
        ];
    }
}
