<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
uses(RefreshDatabase::class, WithFaker::class);
it('a user can create project', function () {
    $attributes = [
        'title'=> $this->faker->sentence,
        'description' => $this->faker->paragraph
    ];
    $this->post('/projects',$attributes);
    $this->assertDatabaseHas('projects', $attributes);
});
