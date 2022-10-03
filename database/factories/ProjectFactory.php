<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{

    public function definition()
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
        ];
    }
}