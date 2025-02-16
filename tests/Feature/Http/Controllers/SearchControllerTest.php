<?php

use App\Http\Controllers\SearchController;
use App\Models\Post;

use function Pest\Laravel\get;

covers(SearchController::class);

it('should search', function (string $params) {
    Post::factory()->published()->createMany(records: 10);
    get(route('search').$params)
        ->assertViewIs('search.index');
})->with(['', '?q=test&type=post']);
