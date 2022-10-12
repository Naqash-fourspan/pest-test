<?php

use App\Models\Project;
use Illuminate\Support\Str;

test('creating a project records activity', function () {
    $project = Project::factory()->create();
    $this->assertCount(1, $project->activity);
    $this->assertEquals('created', $project->activity[0]->description);
});


test('updating a project records activity', function () {
    $project = Project::factory()->create();

    $project->update(['title' => 'Changed']);
    $this->assertCount(2, $project->activity);
    $this->assertEquals('updated', $project->activity->last()->description);
});

test('creating a  new task records project activity', function () {
    $project = Project::factory()->create();

    $project->tasks()->create([
        'uuid' => (string)Str::orderedUuid(),
        'body' => 'Some task',
    ]);
    $this->assertCount(2, $project->activity);
    $this->assertEquals('created_task', $project->activity->last()->description);
});

test('completing a task records project activity', function () {
    $project = Project::factory()->create();

    $project->tasks()->create([
        'uuid' => (string)Str::orderedUuid(),
        'body' => 'Some task',
    ]);
    $this->assertCount(2, $project->activity);
    $this->assertEquals('created_task', $project->activity->last()->description);
});

test('inCompleting a Task', function () {
    $project = Project::factory()->create();

    $project->tasks()->create([
        'uuid' => (string)Str::orderedUuid(),
        'body' => 'Some task',
    ]);

    login($project->owner)
        ->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => true
        ]);

    $this->assertCount(3, $project->activity);

    $this->patch($project->tasks[0]->path(), [
        'body' => 'foobar',
        'completed' => false
    ]);

    $project->refresh();

    $this->assertCount(4, $project->activity);

    $this->assertEquals('incompleted_task', $project->activity->last()->description);
});

test('deleting a task', function () {
    $project = Project::factory()->create();
    $project->tasks()->create([
        'uuid' => (string)Str::orderedUuid(),
        'body' => 'Some task',
    ]);

    $project->tasks[0]->delete();

    $this->assertCount(3, $project->activity);

});
