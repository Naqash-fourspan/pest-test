<?php

use App\Models\Project;
use Illuminate\Support\Str;

test('it has a path', function () {
    $project = Project::factory()->create();
    $this->assertEquals('/project/' . $project->uuid, $project->path());
});


test('it belongs to an owner', function () {

    $project = Project::factory()->create();
    $this->assertInstanceOf('App\Models\User', $project->owner);
});


test('it can add a task', function () {

    $project = Project::factory()->create();
    $task = $project->tasks()->create([
        'uuid' => (string)Str::orderedUuid(),
        'body' => 'Test Task from Unit Test',
    ]);
    $this->assertCount(1, $project->tasks);
    $this->assertTrue($project->tasks->contains($task));
});
