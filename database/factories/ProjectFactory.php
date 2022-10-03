<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => fake()->sentence(),
            'email_verified_at' => fake()->paragraph(),
        ];
    }
}
