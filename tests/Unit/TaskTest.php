<?php

use App\Models\Project;
use App\Models\Task;

test('it belongs to a project', function () {
    $task = Task::factory()->create();

    $this->assertInstanceOf(Project::class, $task->project);
});

test('it has a path', function () {
    $task = Task::factory()->create();
    $this->assertEquals("/project/{$task->project->id}/tasks/{$task->id}", $task->path());
});
