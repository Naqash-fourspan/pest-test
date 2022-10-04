<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a user has projects', function () {

    $user = User::factory()->create();
    $this->assertInstanceOf(Collection::class, $user->projects);
});
