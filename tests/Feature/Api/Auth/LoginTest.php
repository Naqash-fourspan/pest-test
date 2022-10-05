<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

test('it sends user token on correct credentials', function () {

    $user = User::factory()->create();

    $this->json('POST', route('user.login'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertStatus(200)->assertJson(function (AssertableJson $json) use ($user) {
        $json->has('token')
            ->where('user_name', $user->name)
            ->etc();
    });
});

test('it validates wrong password', function () {
    $user = User::factory()->create();

    $this->json('POST', route('user.login'), [
        'email' => $user->email,
        'password' => 'random',
    ])->assertStatus(422)->assertJson(function (AssertableJson $json) use ($user) {
        $json->has('errors')
            ->where('errors.email.0', __('auth.failed'))
            ->etc();
    });
});
