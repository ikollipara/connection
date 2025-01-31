<?php

use App\Http\Controllers\Auth\AuthenticatedUserController;
use App\Http\Requests\LoginRequest;
use App\Mail\Login;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

covers(AuthenticatedUserController::class, LoginRequest::class);

$email = fake()->safeEmail();

beforeEach(function () use ($email) {
    User::factory()->createOne(['email' => $email]);
});

it('should show the creation view', function () {
    $response = get(route('login'));

    $response->assertViewIs('auth.sessions.create');
});

it('should successfully send an email', function () use ($email) {
    Mail::fake();
    $response = post(route('login'), [
        'email' => $email,
    ]);

    $response->assertRedirect(route('login'));
    Mail::assertQueued(Login::class);
});

it('should fail to send an email', function () {
    Mail::fake();
    $response = post(route('login'), [
        'email' => fake()->safeEmail(),
    ]);

    $response->assertRedirect(route('login'));
    Mail::assertNothingQueued();
});

it('should login the given user', function () use ($email) {
    $userId = User::whereEmail($email)->firstOrFail()->id;

    $response = get(route('login.show', $userId));

    $response->assertRedirect(route('user.feed', 'me'));
    assertAuthenticated('web');
});

it('should logout the user', function () use ($email) {
    $user = User::whereEmail($email)->firstOrFail();
    actingAs($user);
    $response = delete(route('logout'));

    assertGuest();
    $response->assertRedirect(route('login'));
});
