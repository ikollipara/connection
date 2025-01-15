<?php

namespace Tests\Feature\Models;

use App\Models\Search;
use App\Models\User;
use Tests\TestCase;

class SearchTest extends TestCase
{
    public function test_search_can_be_created()
    {
        $search = Search::create([
            'user_id' => User::factory()->create()->id,
            'search_params' => ['q' => 'test'],
        ]);
        $this->assertDatabaseCount('searches', 1);
        $this->assertTrue($search->is(Search::sole()));
    }

    public function test_search_belongs_to_a_user()
    {
        $search = Search::create([
            'user_id' => User::factory()->create()->id,
            'search_params' => ['q' => 'test'],
        ]);
        $this->assertNotNull($search->user);
        $this->assertTrue($search->user()->exists());
    }
}
