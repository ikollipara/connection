<?php

use App\Http\Controllers\Api\UserContentCollectionController;
use App\Models\ContentCollection;
use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

covers(UserContentCollectionController::class);

beforeEach(function () {
    /** @var User */
    $this->user = User::factory()->createOne();

    actingAs($this->user);
});

it('should return json of all the entries', function () {
    $post = Post::factory()->createOne();
    $collection = ContentCollection::factory()->createOne(['user_id' => $this->user]);
    $collection->entries()->sync($post->id);
    get(route('api.users.collections.index', ['me', 'content_id' => $post->id]))
        ->assertOk()
        ->assertJsonStructure(['collections'])
        ->assertJsonIsArray('collections')
        ->assertJsonCount(1, 'collections');
});
