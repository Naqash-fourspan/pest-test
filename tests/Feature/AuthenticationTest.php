<?php


use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use function Pest\Laravel\postJson;

uses(LazilyRefreshDatabase::class, WithFaker::class);

it('registers a user', function () {

    $user = User::factory()->raw(['password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
    postJson(route('user.register'), $user)
        ->assertStatus(Response::HTTP_OK);
});
it('registers a user and verified is null', function () {
    $user = User::factory()->raw(['password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);

   postJson(route('user.register'),$user);

    $this->assertDatabaseHas('users', [
        'email' => $user['email'],
        'email_verified_at' => null,
    ]);
});
test('validate uuid field is required', function () {
    $user = [
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];

    postJson(route('user.register'), $user)
        ->assertStatus(Response::HTTP_BAD_REQUEST)
        ->assertJson(['message' => 'The uuid field is required.']);
});

test('validate name field is required', function () {
    $user = [
        'uuid' => (string) Str::orderedUuid(),
        'email' => fake()->unique()->safeEmail(),
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];

    postJson(route('user.register'), $user)
        ->assertStatus(Response::HTTP_BAD_REQUEST)
        ->assertJson(['message' => 'The name field is required.']);
});

test('password mismatch on register', function () {
    $user = User::factory()->raw([
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/45i',
        'password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ]);

    postJson(route('user.register'), $user)
        ->assertStatus(Response::HTTP_BAD_REQUEST)
        ->assertJson(['message' => 'The password confirmation does not match.']);

});


test('verify unique email on register', function () {
    $user = User::factory()->create();
    $newUser = User::factory()->raw([
        'email' => $user->email,
    ]);

    postJson(route('user.register'), $newUser)
        ->assertStatus(Response::HTTP_BAD_REQUEST)
        ->assertJson(['message' => 'The email has already been taken.']);

});

test('it sends user token on correct credentials', function () {

    $user = User::factory()->create();

    postJson(route('user.login'), [
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

    postJson(route('user.login'), [
        'email' => $user->email,
        'password' => 'random',
    ])->assertStatus(422)->assertJson(function (AssertableJson $json) use ($user) {
        $json->has('errors')
            ->where('errors.email.0', __('auth.failed'))
            ->etc();
    });
});

