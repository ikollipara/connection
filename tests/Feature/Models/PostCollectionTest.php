<?php

namespace Tests\Feature\Models;

use App\Models\PostCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostCollectionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_post_collections_can_have_entries()
    {
        $collection = PostCollection::factory()
            ->hasEntries(5)
            ->create();

        $this->assertEquals(5, $collection->entries->count());
    }

    public function test_post_collection_has_an_entry()
    {
        $collection = PostCollection::factory()
            ->hasEntries(1)
            ->create();

        $this->assertNotNull($collection->entries->first());
        $this->assertTrue($collection->hasEntry($collection->entries->first()));
    }
}
