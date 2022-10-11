<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{

    public function definition()
    {
        return [
            'uuid' => (string) Str::orderedUuid(),
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraph(),
            'notes' => 'General notes here.',
            'owner_id' => User::factory()->create()

        ];
    }
}
