<?php

use App\Http\Controllers\UserContentCollectionEntryController;
use App\Models\ContentCollection;
use App\Models\Entry;
use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\delete;

covers(UserContentCollectionEntryController::class);

beforeEach(function () {
    /** @var User */
    $this->user = User::factory()->createOne();
    actingAs($this->user);
});

it('should destroy a collection entry', function () {
    $collection = ContentCollection::factory()->createOne();
    $content = Post::factory()->createOne();
    $collection->entries()->attach($content);
    $entry = Entry::query()->whereCollectionId($collection->id)->whereContentId($content->id)->firstOrFail();

    delete(route('users.collections.entries.destroy', ['me', $collection, $entry]))
        ->assertRedirect();

    assertDatabaseCount('entries', 0);
});
