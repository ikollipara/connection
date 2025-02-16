<?php

use App\Http\Controllers\UserProfileController;
use App\Models\User;
use App\Models\UserProfile;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

covers(UserProfileController::class);

it('should show the profile for the given user', function () {
    $user = User::factory()->has(UserProfile::factory(), 'profile')->createOne();

    get(route('users.profile.show', $user->id))
        ->assertOk()
        ->assertViewIs('users.profile.show');
});

it('should allow editting', function () {
    /** @var User */
    $user = User::factory()->has(UserProfile::factory(), 'profile')->createOne();

    actingAs($user)
        ->get(route('users.profile.edit', 'me'))
        ->assertOk()
        ->assertViewIs('users.profile.edit');
});
it('should allow updating', function () {
    /** @var User */
    $user = User::factory()->has(UserProfile::factory(), 'profile')->createOne();

    $school = $user->profile->school;

    actingAs($user)
        ->put(route('users.profile.update', 'me'), ['school' => fake()->word()])
        ->assertRedirect();

    $user->refresh();
    $user->profile->refresh();
    expect($user->profile->school)->not->toEqual($school);
});

it('should fail to allow editing (auth)', function () {
    $user1 = User::factory()->has(UserProfile::factory(), 'profile')->createOne();
    $user2 = User::factory()->has(UserProfile::factory(), 'profile')->createOne();

    get(route('users.profile.edit', $user1->id))
        ->assertRedirect();
});

it('should fail to allow editing (owner)', function () {
    /** @var User */
    $user1 = User::factory()->has(UserProfile::factory(), 'profile')->createOne();

    /** @var User */
    $user2 = User::factory()->has(UserProfile::factory(), 'profile')->createOne();

    actingAs($user2)
        ->get(route('users.profile.edit', $user1->id))
        ->assertRedirect();
});

it('should fail to allow updating (owner)', function () {
    /** @var User */
    $user1 = User::factory()->has(UserProfile::factory(), 'profile')->createOne();

    /** @var User */
    $user2 = User::factory()->has(UserProfile::factory(), 'profile')->createOne();

    actingAs($user2)
        ->put(route('users.profile.update', $user1->id))
        ->assertRedirect();
});
