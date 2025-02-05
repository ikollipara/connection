<?php

use App\Http\Controllers\UserPostPublishController;
use App\Models\Post;
use App\Models\User;
use App\ValueObjects\Metadata;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

covers(UserPostPublishController::class);


it('should successfully publish the post (existing)', function () {
    /** @var User */
    $user = User::factory()->createOne();

    /** @var Post */
    $post = Post::factory()->published()->createOne(['user_id' => $user->id]);

    actingAs($user)
        ->put(route('users.posts.publish', [$user, $post], Metadata::fromFaker(fake())->toArray()))
        ->assertRedirect()
        ->assertSessionHas('saved');
});

it('should successfully publish the post (draft)', function () {
    /** @var User */
    $user = User::factory()->createOne();

    /** @var Post */
    $post = Post::factory()->draft()->createOne(['user_id' => $user->id]);

    actingAs($user)
        ->put(route('users.posts.publish', [$user, $post], Metadata::fromFaker(fake())->toArray()))
        ->assertRedirect()
        ->assertSessionHas('published');
});

it('should return an error due to authorization', function () {
    /** @var User */
    $user = User::factory()->createOne();
    /** @var User */
    $user1 = User::factory()->createOne();
    /** @var Post */
    $post = Post::factory()->draft()->createOne(['user_id' => $user->id]);
    actingAs($user1)
        ->put(route('users.posts.publish', [$user, $post], Metadata::fromFaker(fake())->toArray()))
        ->assertRedirect()
        ->assertSessionHas('error');
});
