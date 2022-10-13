<?php

use App\Models\Project;
use App\Models\User;


test('it has a user', function () {
    $user = User::factory()->create();

    $project = Project::factory()->create(["owner_id" => $user]);
    $this->assertEquals($user->id, $project->activity->first()->user->id);
});
