<?php

use App\Models\Project;
use App\Models\Task;
use App\Services\TaskService;

test('it belongs to a project', function () {
    $task = Task::factory()->create();

    $this->assertInstanceOf(Project::class, $task->project);
});

test('it has a path', function () {
    $task = Task::factory()->create();
    $this->assertEquals("/project/{$task->project->uuid}/tasks/{$task->uuid}", $task->path());
});

test('it can be completed', function () {
    $task = Task::factory()->create();
    $this->assertFalse($task->completed);
    (new TaskService())->completeTask($task);
    $this->assertTrue($task->fresh()->completed);
});

test('it can be inCompleted', function () {
    $task = Task::factory()->create([
        'completed' => true,
    ]);
    $this->assertTrue($task->completed);
    (new TaskService())->incompleteTask($task);
    $this->assertFalse($task->fresh()->completed);
});
