<?php

use App\Http\Controllers\UserContentCollectionController;
use App\Models\ContentCollection;
use App\Models\User;

use function Pest\Laravel\actingAs;

covers(UserContentCollectionController::class);

beforeEach(function () {
    $this->user = User::factory()->createOne();
    $this->collection = ContentCollection::factory()->draft()->createOne(['user_id' => $this->user->id]);
});

it('should render the index page', function () {
    actingAs($this->user)
        ->get(route('users.collections.index', 'me'))
        ->assertOk()
        ->assertViewIs('users.collections.index');
});

it('should render the create page', function () {
    actingAs($this->user)
        ->get(route('users.collections.create', 'me'))
        ->assertOk()
        ->assertViewIs('users.collections.create');
});

it('should create a new collection', function (string $title, string $body) {
    actingAs($this->user)
        ->post(route('users.collections.store', 'me'), [
            'body' => $body,
            'title' => $title,
        ])
        ->assertRedirect()
        ->assertSessionHas('success');
})->with([
    ['', ''],
    [fake()->word(), ''],
    ['', '{"blocks": []}'],
]);

it('should render the edit page', function () {
    actingAs($this->user)
        ->get(route('users.collections.edit', ['me', $this->collection]))
        ->assertOk()
        ->assertViewIs('users.collections.edit');
});

it('should update a collection', function (string $title, string $body) {
    actingAs($this->user)
        ->put(route('users.collections.update', ['me', $this->collection]), [
            'body' => $body,
            'title' => $title,
        ])
        ->assertRedirect()
        ->assertSessionHas('success');
})->with([
    ['', ''],
    [fake()->word(), ''],
    ['', '{"blocks": []}'],
]);
