<?php

namespace Tests\Feature\Models;

use App\Models\Search;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

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
        /** @var Search */
        $search = Search::create([
            'user_id' => User::factory()->create()->id,
            'search_params' => ['q' => 'test'],
        ]);
        $this->assertNotNull($search->user->id);
        $this->assertTrue($search->user()->exists());
    }

    public function test_search()
    {
        /** @var Search */
        $search = new Search([
            'user_id' => User::factory()->create()->id,
        ]);

        foreach (['post', 'collection', 'event'] as $type) {
            $results = $search->search(
                ['q' => 'test', 'type' => $type],
            );
            $this->assertCount(0, $results);
        }
    }

    public function test_search_failure()
    {
        /** @var Search */
        $search = new Search([
            'user_id' => User::factory()->create()->id,
        ]);

        $this->expectException(InvalidArgumentException::class);
        $search->search(['q' => 'test', 'type' => 'invalid']);
    }
}
