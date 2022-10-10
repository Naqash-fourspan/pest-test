<?php

use App\Models\Project;

test('it has a path', function () {
    $project = Project::factory()->create();
    $this->assertEquals('/project/' . $project->id, $project->path());
});


test('it belongs to an owner', function () {

    $project = Project::factory()->create();
    $this->assertInstanceOf('App\Models\User', $project->owner);
});



test('it can add a task', function () {

    $project = Project::factory()->create();
    $task =$project->addTask('Test Task from Unit Test');
    $this->assertCount(1,$project->tasks);
    $this->assertTrue($project->tasks->contains($task));
});
