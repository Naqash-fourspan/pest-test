<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{

    public function definition()
    {
        return [
            'body' => fake()->sentence,
            'project_id' => Project::factory()->create(),
        ];
    }
}
