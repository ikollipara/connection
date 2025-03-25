<?php

use App\Http\Controllers\ContentCollectionController;
use App\Models\ContentCollection;
use App\Models\User;
use App\Models\UserProfile;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

covers(ContentCollectionController::class);

beforeEach(function () {
    /** @var User */
    $this->user = User::factory()->createOne();
    actingAs($this->user);
});

it('should return the correct content collection', function () {
    $user = User::factory()->has(UserProfile::factory(), 'profile')->createOne();
    $collection = ContentCollection::factory()->createOne(['user_id' => $user]);
    get(route('collections.show', $collection))
        ->assertViewIs('collections.show')
        ->assertViewHas('collection', $collection);

    expect($collection->views())->toEqual(1);
});
