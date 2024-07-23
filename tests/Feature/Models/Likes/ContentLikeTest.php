<?php

namespace Tests\Feature\Models\Likes;

use App\Models\Likes\ContentLike;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContentLikeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_content_like_can_be_created()
    {
        $like = ContentLike::factory()->create();
        $this->assertDatabaseCount("content_likes", 1);
        $this->assertTrue($like->is(ContentLike::sole()));
    }

    public function test_content_like_belongs_to_a_user()
    {
        $like = ContentLike::factory()->create();
        $this->assertNotNull($like->user);
        $this->assertTrue($like->user()->exists());
    }

    public function test_content_like_belongs_to_content()
    {
        $like = ContentLike::factory()->create();
        $this->assertNotNull($like->content);
        $this->assertTrue($like->content()->exists());
    }

    public function test_content_like_can_be_scoped_to_this_month()
    {
        $this->travelTo(now()->subMonth());
        ContentLike::factory()->create();
        $this->travelBack();
        ContentLike::factory()->create();
        $this->assertEquals(1, ContentLike::thisMonth()->count());
    }

    public function test_content_like_can_be_scoped_to_last_month()
    {
        $this->travelTo(now()->subMonth());
        ContentLike::factory()->create();
        $this->travelBack();
        ContentLike::factory()->create();
        $this->assertEquals(1, ContentLike::lastMonth()->count());
    }
}
