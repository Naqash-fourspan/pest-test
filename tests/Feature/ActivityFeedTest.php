<?php

use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Str;

test('creating a project records activity', function () {
    $project = Project::factory()->create();
    $this->assertCount(1, $project->activity);
    tap($project->activity->last(), function ($activity) {
        $this->assertEquals('created', $activity->description);
        $this->assertNull($activity->changes);
    });
});


test('updating a project records activity', function () {
    $project = Project::factory()->create();
    $originalTitle = $project->title;
    $project->update(['title' => 'Changed']);
    $this->assertCount(2, $project->activity);
    tap($project->activity->last(), function ($activity) use ($originalTitle) {
        $this->assertEquals('updated', $activity->description);

        $expected = [
            'before' => ['title' => $originalTitle],
            'after' => ['title' => 'Changed']
        ];

        $this->assertEquals($expected, $activity->changes);
    });
});

test('creating a new task', function () {
    $project = Project::factory()->create();

    $project->tasks()->create([
        'uuid' => (string)Str::orderedUuid(),
        'body' => 'Some task',
    ]);
    $this->assertCount(2, $project->activity);
    tap($project->activity->last(), function ($activity) {
        $this->assertEquals('created_task', $activity->description);
        $this->assertInstanceOf(Task::class, $activity->subject);
        $this->assertEquals('Some task', $activity->subject->body);
    });
});

test('completing a task', function () {
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
    tap($project->activity->last(), function ($activity) {
        $this->assertEquals('completed_task', $activity->description);
        $this->assertInstanceOf(Task::class, $activity->subject);
    });
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
