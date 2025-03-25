<?php

use App\Http\Controllers\ContentCollectionCommentController;
use App\Models\Comment;
use App\Models\ContentCollection;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

covers(ContentCollectionCommentController::class);

beforeEach(function () {
    $this->collection = ContentCollection::factory()->createOne();
    actingAs($this->collection->user);
});

it('should return the correct view', function () {
    get(route('collections.comments.index', $this->collection))
        ->assertOk()
        ->assertViewIs('content.comments.index');
});

it('should create a new comment', function (?string $parent_id) {
    post(route('collections.comments.store', $this->collection), [
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
