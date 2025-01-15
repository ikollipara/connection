<?php

namespace Tests\Feature;

use App\Models\Entry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EntryTest extends TestCase
{
    use RefreshDatabase;

    public function test_entry_can_be_created()
    {
        $entry = Entry::factory()->create();
        $this->assertDatabaseCount('entries', 1);
        $this->assertTrue($entry->is(Entry::sole()));
    }

    public function test_entry_belongs_to_a_content()
    {
        $entry = Entry::factory()->create();
        $this->assertNotNull($entry->content);
        $this->assertTrue($entry->content()->exists());
    }

    public function test_entry_belongs_to_a_collection()
    {
        $entry = Entry::factory()->create();
        $this->assertNotNull($entry->collection);
        $this->assertTrue($entry->collection()->exists());
    }
}
