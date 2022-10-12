<?php

use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;


test('guest user cannot add tasks to project', function () {
    $project = Project::factory()->create();
    $this->post($project->path() . '/tasks')->assertRedirect('login');
});

test('only the owner of the project may add tasks', function () {
    login();
    $project = Project::factory()->create();
    $this->post($project->path() . '/tasks', ['body' => 'Task 1'])
        ->assertStatus(Response::HTTP_FORBIDDEN);

    $this->assertDatabaseMissing('tasks', ['body' => 'Task 1']);

});

test('a project can have task', function () {
    $this->withoutExceptionHandling();
    login();
    $project = auth()->user()->projects()->create(Project::factory()->raw());
    $this->post($project->path() . '/tasks', ['body' => 'Task 1', 'uuid' => (string)Str::orderedUuid()]);

    $this->get($project->path())
        ->assertSee('Task 1');

});

test('a task requires body', function () {
    login();
    $project = auth()->user()->projects()->create(Project::factory()->raw());
    $attributes = Task::factory()->raw(['body' => '']);
    $this->post($project->path() . '/tasks', [$attributes])->assertSessionHasErrors('body');
});

test('a user can update projects general notes', function () {
    $project = Project::factory()->create();

    login($project->owner)->patch($project->path(), $attributes = ['notes' => 'Changed']);

    $this->assertDatabaseHas('projects', $attributes);
});

test('a task can be updated', function () {
    $this->withoutExceptionHandling();

    login();
    $project = auth()->user()->projects()->create(Project::factory()->raw());
    $task = $project->tasks()->create([
        'uuid' => (string)Str::orderedUuid(),
        'body' => 'test task',
    ]);

    $this->patch($project->path() . '/tasks/' . $task->uuid, [
        'body' => 'changed',
        'completed' => true
    ]);

    $this->assertDatabaseHas('tasks', [
        'body' => 'changed',
        'completed' => true
    ]);

});

test('a task can be completed', function () {
    $this->withoutExceptionHandling();
    login();
    $project = auth()->user()->projects()->create(Project::factory()->raw());
    $task = $project->tasks()->create([
        'uuid' => (string)Str::orderedUuid(),
        'body' => 'test task',
    ]);
    $this->patch($task->path(), [
        'body' => 'changed',
        'completed' => true
    ]);

    $this->assertDatabaseHas('tasks', [
        'body' => 'changed',
        'completed' => true
    ]);
});

test('a task can be inCompleted', function () {
    $this->withoutExceptionHandling();
    login();
    $project = auth()->user()->projects()->create(Project::factory()->raw());
    $task = $project->tasks()->create([
        'uuid' => (string)Str::orderedUuid(),
        'body' => 'test task',
    ]);

    $this->patch($task->path(), [
        'body' => 'changed',
        'completed' => false
    ]);

    $this->assertDatabaseHas('tasks', [
        'body' => 'changed',
        'completed' => false
    ]);
});
