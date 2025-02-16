<?php

use App\Http\Controllers\UserPostController;
use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\actingAs;

covers(UserPostController::class);

beforeEach(function () {
    $this->user = User::factory()->createOne();
    $this->post = Post::factory()->draft()->createOne(['user_id' => $this->user->id]);
});

it('should render the index page', function () {
    actingAs($this->user)
        ->get(route('users.posts.index', 'me'))
        ->assertOk()
        ->assertViewIs('users.posts.index');
});

it('should render the create page', function () {
    actingAs($this->user)
        ->get(route('users.posts.create', 'me'))
        ->assertOk()
        ->assertViewIs('users.posts.create');
});

it('should create a new post', function (string $title, string $body) {
    actingAs($this->user)
        ->post(route('users.posts.store', 'me'), [
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
        ->get(route('users.posts.edit', ['me', $this->post]))
        ->assertOk()
        ->assertViewIs('users.posts.edit');
});

it('should update a post', function (string $title, string $body) {
    actingAs($this->user)
        ->put(route('users.posts.update', ['me', $this->post]), [
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
