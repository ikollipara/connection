<?php

use App\Http\Controllers\PostCommentController;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

covers(PostCommentController::class);

beforeEach(function () {
    $this->post = Post::factory()->createOne();
    actingAs($this->post->user);
});

it('should return the correct view', function () {
    get(route('posts.comments.index', $this->post))
        ->assertOk()
        ->assertViewIs('content.comments.index');
});

it('should create a new comment', function (?string $parent_id) {
    post(route('posts.comments.store', $this->post), [
        'body' => fake()->paragraph(),
        'user_id' => User::factory()->createOne()->id,
        'parent_id' => $parent_id,
    ])
        ->assertRedirect()
        ->assertSessionHas('success');
})->with([
    fn () => Comment::factory()->createOne()->id,
    null,
]);
