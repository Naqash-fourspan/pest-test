<?php

use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\post;

uses(RefreshDatabase::class, WithFaker::class);

it('a user can create project', function () {
    $attributes = [
        'title' => $this->faker->sentence,
        'description' => $this->faker->paragraph
    ];
    post('/projects', $attributes)->assertRedirect('/projects');
    $this->assertDatabaseHas('projects', $attributes);
    $this->get('/projects')->assertSee($attributes['title']);
});

it('a project requires a title', function () {
    $attributes = Project::factory()->raw(['title'=> '']);
    post('/projects', [$attributes])->assertSessionHasErrors('title');
});

it('a project requires a description', function () {
    $attributes = Project::factory()->raw(['title'=> '']);
    post('/projects', [$attributes])->assertSessionHasErrors('description');
});
