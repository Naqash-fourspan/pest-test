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
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'owner_id' => function () {
                return User::factory()->create()->id;
            }
        ];
    }
}
