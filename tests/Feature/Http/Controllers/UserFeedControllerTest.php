<?php

use App\Http\Controllers\UserFeedController;
use App\Models\Post;
use App\Models\User;
use App\Models\UserProfile;

use function Pest\Laravel\actingAs;

covers(UserFeedController::class);

it('should display the user\'s feed', function () {
    /** @var User */
    $user = User::factory()->has(UserProfile::factory(), 'profile')->createOne();

    Post::factory()->published()->createMany(records: 10);

    actingAs($user)
        ->get(route('user.feed', 'me'))
        ->assertOk()
        ->assertViewIs('users.feed');
});
