<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\post;

uses(RefreshDatabase::class, WithFaker::class);


test('only authenticated users can create project', function () {

    $attributes = Project::factory()->raw();
    $this->post('/projects', $attributes)->assertRedirect('login');
});


it('a user can create project', function () {
    $this->withoutExceptionHandling();
    $user = User::factory()->create();
    $attributes = [
        'title' => $this->faker->sentence,
        'description' => $this->faker->paragraph
    ];
    $this->actingAs($user)
        ->post('/projects', $attributes)
        ->assertRedirect('/projects');
    $this->assertDatabaseHas('projects', $attributes);
    $this->get('/projects')->assertSee($attributes['title']);
});

it('a user can view a project', function () {
    $user = User::factory()->create();
    $this->withoutExceptionHandling();
    $project = Project::factory()->create();
    $this->actingAs($user)->get('/project/'.$project->id)
        ->assertSee($project->title)
        ->assertSee($project->description);
});

it('a project requires a title', function () {
    $user = User::factory()->create();
    $attributes = Project::factory()->raw(['title' => '']);
    $this->actingAs($user)->post('/projects', [$attributes])->assertSessionHasErrors('title');
});

it('a project requires a description', function () {
    $user = User::factory()->create();
    $attributes = Project::factory()->raw(['description' => '']);
    $this->actingAs($user)
        ->post('/projects', [$attributes])
        ->assertSessionHasErrors('description');
});
