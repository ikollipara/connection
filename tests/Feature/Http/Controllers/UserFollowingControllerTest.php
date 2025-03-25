<?php

use App\Http\Controllers\UserFollowingController;
use App\Models\User;
use App\Models\UserProfile;

use function Pest\Laravel\get;

covers(UserFollowingController::class);

it('should return the list of user followers', function () {
    $user = User::factory()->has(UserProfile::factory(), 'profile')->createOne();
    $user->followers()->attach(User::factory()->has(UserProfile::factory(), 'profile')->createMany(records: 10));
    get(route('users.following', $user))
        ->assertOk()
        ->assertViewIs('users.following');
});
