<?php

use App\Http\Controllers\Api\LikeLogController;
use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

covers(LikeLogController::class);

beforeEach(function () {
    $this->user = User::factory()->createOne();
});

it('should like the given content', function () {
    /** @var Post */
    $content = Post::factory()->createOne();
    actingAs($this->user)
        ->post(route('api.like'), [
            'model_id' => $content->id,
            'model_type' => Post::class,
        ])
        ->assertOk();
});

it('should unlike the given content', function () {
    /** @var Post */
    $content = Post::factory()->createOne();
    actingAs($this->user);
    $content->like();
    post(route('api.like'), [
        'model_id' => $content->id,
        'model_type' => Post::class,
    ])
        ->assertOk();
});

it('should fail to like the given content', function () {
    /** @var Post */
    $content = Post::factory()->createOne();
    actingAs($this->user)
        ->post(route('api.like'), [
            'model_id' => $content->id,
            'model_type' => 'invalid-class',
        ])
        ->assertInternalServerError();
});
