<?php

use App\Models\Project;
use App\Models\Task;
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
    $this->post($project->path() . '/tasks', ['body' => 'Task 1']);

    $this->get($project->path())
        ->assertSee('Task 1');

});

test('a task requires body', function () {
    login();
    $project = auth()->user()->projects()->create(Project::factory()->raw());
    $attributes = Task::factory()->raw(['body' => '']);
    $this->post($project->path() . '/tasks', [$attributes])->assertSessionHasErrors('body');
});

test('a task can be updated', function () {
    $this->withoutExceptionHandling();

    login();
    $project = auth()->user()->projects()->create(Project::factory()->raw());
    $task = $project->addTask('test task');

    $this->patch($project->path() . '/tasks/' . $task->id, [
        'body' => 'changed',
        'completed' => true
    ]);

    $this->assertDatabaseHas('tasks', [
        'body' => 'changed',
        'completed' => true
    ]);

});
