<?php

use App\Http\Controllers\UserContentCollectionPublishController;
use App\Models\ContentCollection;
use App\Models\User;
use App\ValueObjects\Metadata;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

covers(UserContentCollectionPublishController::class);


it('should successfully publish the post (existing)', function () {
    /** @var User */
    $user = User::factory()->createOne();

    /** @var ContentCollection */
    $collection = ContentCollection::factory()->published()->createOne(['user_id' => $user->id]);

    actingAs($user)
        ->put(route('users.collections.publish', [$user, $collection], Metadata::fromFaker(fake())->toArray()))
        ->assertRedirect()
        ->assertSessionHas('saved');
});

it('should successfully publish the ContentCollection (draft)', function () {
    /** @var User */
    $user = User::factory()->createOne();

    /** @var ContentCollection */
    $collection = ContentCollection::factory()->draft()->createOne(['user_id' => $user->id]);

    actingAs($user)
        ->put(route('users.collections.publish', [$user, $collection], Metadata::fromFaker(fake())->toArray()))
        ->assertRedirect()
        ->assertSessionHas('published');
});

it('should return an error due to authorization', function () {
    /** @var User */
    $user = User::factory()->createOne();
    /** @var User */
    $user1 = User::factory()->createOne();
    /** @var ContentCollection */
    $collection = ContentCollection::factory()->draft()->createOne(['user_id' => $user->id]);
    actingAs($user1)
        ->put(route('users.collections.publish', [$user, $collection], Metadata::fromFaker(fake())->toArray()))
        ->assertRedirect()
        ->assertSessionHas('error');
});
