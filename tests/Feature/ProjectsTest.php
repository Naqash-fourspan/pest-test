<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use function Pest\Laravel\post;

uses( WithFaker::class);

test('guest cannot manage projects', function () {
    $project = Project::factory()->create();
    $this->get('/projects')->assertRedirect('login');
    $this->get($project->path())->assertRedirect('login');
    $this->post('/projects', $project->toArray())->assertRedirect('login');
});

test('a user can update their project', function () {
    $this->withoutExceptionHandling();
    login();
    $project = Project::factory()->create(['owner_id' => auth()->id()]);
    $this->patch($project->path(), [
        'notes' => 'Changed'
    ])->assertRedirect($project->path());

    $this->assertDatabaseHas('projects', ['notes' => 'Changed']);
});

test('a user can view their project', function () {
    $this->withoutExceptionHandling();
    login();
    $project = Project::factory()->create(['owner_id' => auth()->id()]);
    $this->get('/project/' . $project->uuid)->assertSee($project->title)->assertSee($project->description);

});

test('an authenticated user cannot update the project of the others', function () {

    $project = Project::factory()->create();

    login()->patch($project->path(), [])->assertStatus(403);

});

test('an authenticated user cannot view the project of the others', function () {
    $project = Project::factory()->create();
    login()->get($project->path())->assertStatus(403);

});

test('a project requires a title', function () {
    $attributes = Project::factory()->raw(['title' => '']);
    login()->post('/projects', [$attributes])->assertSessionHasErrors('title');
});

test('a project requires a description', function () {
    $attributes = Project::factory()->raw(['description' => '']);
    login()->post('/projects', [$attributes])->assertSessionHasErrors('description');
});
test('unauthorized users cannot delete projects', function () {
    $project = Project::factory()->create();
    $this->delete($project->path())
        ->assertRedirect('/login');
    login();
    $this->delete($project->path())
        ->assertStatus(403);
});

test('a user can delete a project', function () {
    $project = Project::factory()->create();
    login($project->owner)
        ->delete($project->path())
        ->assertRedirect('/projects');
    $this->assertDatabaseMissing('projects', $project->only('id'));
});
