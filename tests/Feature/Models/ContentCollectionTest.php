<?php

use App\Models\ContentCollection;
use App\Models\Post;

it('should have n entries', function (int $count) {
    /** @var ContentCollection */
    $contentCollection = ContentCollection::factory()->createOne();
    /** @var Collection<Post> */
    $entries = Post::factory($count)->createMany();

    $contentCollection->entries()->sync($entries);

    expect($contentCollection->entries)->toHaveCount($count);
})->with([3, 4, 5]);

it('should return true for hasEntry', function () {
    /** @var ContentCollection */
    $contentCollection = ContentCollection::factory()->createOne();
    /** @var Collection<Post> */
    $entries = Post::factory(3)->createMany();

    $contentCollection->entries()->sync($entries);

    $result = $contentCollection->hasEntry($entries[0]);

    expect($result)->toBeTrue();
});

it('should scope content collection to include those with this query', function () {
    /** @var ContentCollection */
    $contentCollection = ContentCollection::factory()->createOne();
    /** @var Collection<Post> */
    $entries = Post::factory(3)->createMany();

    $contentCollection->entries()->sync($entries);

    expect(ContentCollection::query()->withHasEntry($entries[0])->count())->toEqual(1);
});

it('should return the query unchanged', function () {
    /** @var ContentCollection */
    $contentCollection = ContentCollection::factory()->createOne();
    /** @var Collection<Post> */
    $entries = Post::factory(3)->createMany();

    $contentCollection->entries()->sync($entries);

    expect(ContentCollection::query()->withHasEntry()->count())->toEqual(1);
});
