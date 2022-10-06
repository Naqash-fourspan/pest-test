<?php

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

uses(LazilyRefreshDatabase::class, WithFaker::class);


it('registers a user', function () {

    $user = User::factory()->raw(['password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
    $this->json('POST', route('user.register'), $user)
        ->assertStatus(Response::HTTP_OK);
});
it('registers a user and verified is null', function () {
    $user = User::factory()->raw(['password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);

    $this->json('POST',route('user.register'),$user);

    $this->assertDatabaseHas('users', [
        'email' => $user['email'],
        'email_verified_at' => null,
    ]);
});
test('it validate password required', function () {
    $newUser = User::factory()->raw(['password' => '']);
    $response = $this->postJson(route('user.register'), $newUser);
    $response->assertStatus(Response::HTTP_BAD_REQUEST)
        ->assertJson(['message' => 'The password field is required.']);
});

test('it validate email required', function () {
    $newUser = User::factory()->raw(['email' => '']);
    $response = $this->postJson(route('user.register'), $newUser);
    $response->assertStatus(Response::HTTP_BAD_REQUEST)
        ->assertJson(['message' => 'The email field is required.']);
});
