<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{

    public function definition()
    {
        return [
            'uuid' => (string)Str::orderedUuid(),
            'body' => fake()->sentence,
            'project_id' => Project::factory()->create(),
            'completed' => false
        ];
    }
}
