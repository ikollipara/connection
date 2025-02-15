<?php

use App\Http\Controllers\UserFollowerController;
use App\Models\User;
use App\Models\UserProfile;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

covers(UserFollowerController::class);

beforeEach(function () {
    /** @var User */
    $this->user = User::factory()->has(UserProfile::factory(), 'profile')->createOne();

    actingAs($this->user);
});

it('should display all of the followers', function () {
    get(route('users.followers.index', 'me'))
        ->assertOk()
        ->assertViewIs('users.followers.index');
});

it('should add a new follower', function () {
    $user = User::factory()->createOne();

    post(route('users.followers.store', 'me'), ['follower_id' => $user->id])
        ->assertRedirect();

    expect($this->user->followers->count())->toEqual(1);
});

it('should destroy a new follower', function () {
    $user = User::factory()->createOne();

    delete(route('users.followers.destroy', ['me', $user->id]))
        ->assertRedirect();

    expect($this->user->followers->count())->toEqual(0);
});
