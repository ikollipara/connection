<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\User;
use App\Models\UserProfile;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

covers(RegisteredUserController::class);


it('should get the correct view', function () {
    get(route('register'))
        ->assertOk()
        ->assertViewIs('auth.register.create');
});

it('should redirect if not guest', function () {
    /** @var User */
    $user = User::factory()->createOne();
    actingAs($user)
        ->get(route('register'))
        ->assertRedirect();
});

it('should create a user with a profile', function ($consented) {;
    $data = array_merge(
        Arr::except(User::factory()->makeOne()->toArray(), ['avatar', 'id', 'email_verified_at']),
        Arr::except(UserProfile::factory()->makeOne()->toArray(), ['user_id', 'bio', 'is_preservice']),
        [
            'bio' => '{"blocks": []}',
            'consented' => ['full_name' => $consented]
        ]
    );
    post(route('register'), $data)
        ->assertRedirect()
        ->assertSessionHas('success');
})->with([fake()->name(), '', null]);
