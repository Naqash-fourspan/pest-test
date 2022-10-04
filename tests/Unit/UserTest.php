<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

test('a user has projects', function () {

    $user = User::factory()->create();
    $this->assertInstanceOf(Collection::class, $user->projects);
});
