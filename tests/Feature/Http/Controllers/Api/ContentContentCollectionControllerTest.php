<?php

use App\Http\Controllers\Api\ContentContentCollectionController;
use App\Models\ContentCollection;
use App\Models\Post;

use function Pest\Laravel\post;

covers(ContentContentCollectionController::class);

it('should add the content to all of the collections (post)', function () {
    $content = Post::factory()->createOne();
    $collections = ContentCollection::factory()->createMany(records: 10);
    post(route('api.posts.collections.store', $content), [
        'collections' => $collections->pluck('id')->toArray(),
    ])
        ->assertNoContent();
});

it('should add the content to all of the collections (collection)', function () {
    $content = ContentCollection::factory()->createOne();
    $collections = ContentCollection::factory()->createMany(records: 10);
    post(route('api.collections.collections.store', $content), [
        'collections' => $collections->pluck('id')->toArray(),
    ])
        ->assertNoContent();
});
