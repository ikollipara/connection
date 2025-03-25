<?php

use App\Http\Controllers\PostController;
use App\Models\Post;
use App\Models\User;
use App\Models\UserProfile;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

covers(PostController::class);

beforeEach(function () {
    /** @var User */
    $this->user = User::factory()->createOne();
    actingAs($this->user);
});

it('should return the correct post', function () {
    $user = User::factory()->has(UserProfile::factory(), 'profile')->createOne();
    $post = Post::factory()->createOne(['user_id' => $user]);
    get(route('posts.show', $post))
        ->assertViewIs('posts.show')
        ->assertViewHas('post', $post);

    expect($post->views())->toEqual(1);
});
