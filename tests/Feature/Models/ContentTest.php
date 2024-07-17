<?php

namespace Tests\Feature\Models;

use App\Enums\Status;
use App\Models\Content;
use App\Models\Likes\ContentLike;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_content_can_be_created()
    {
        $content = Content::factory()->create();
        $this->assertDatabaseCount("content", 1);
        $this->assertTrue($content->is(Content::sole()));
    }

    public function test_content_recently_published()
    {
        $content = Content::factory()
            ->draft()
            ->create();
        $content->published = true;
        $content->save();
        $this->assertTrue($content->was_recently_published);
    }

    public function test_status_is_correct()
    {
        $content = Content::factory()
            ->draft()
            ->create();
        $this->assertTrue(Status::draft()->equals($content->status));

        $content->published = true;
        $content->save();
        $this->assertTrue(Status::published()->equals($content->status));

        $content->delete();
        $this->assertTrue(Status::archived()->equals($content->status));
    }

    public function test_status_scope()
    {
        Content::factory()
            ->count(3)
            ->draft()
            ->create();
        Content::factory()
            ->count(2)
            ->published()
            ->create();
        $content = Content::factory()->create();
        $content->delete();

        $this->assertEquals(3, Content::status(Status::draft())->count());
        $this->assertEquals(2, Content::status(Status::published())->count());
        $this->assertEquals(1, Content::status(Status::archived())->count());
    }

    public function test_where_published_scope()
    {
        Content::factory()
            ->count(3)
            ->draft()
            ->create();
        Content::factory()
            ->count(2)
            ->published()
            ->create();
        $content = Content::factory()->create();
        $content->delete();

        $this->assertEquals(2, Content::wherePublished()->count());
    }

    public function test_top_last_month_scope()
    {
        $this->markTestSkipped(
            "This test is too flaky and needs to be rewritten.",
        );
        $users = User::factory()
            ->count(3)
            ->create();
        Content::factory()
            ->count(2)
            ->published()
            ->create([
                "created_at" => now()->subMonths(2),
            ]);
        /** @var Content */
        $content = Content::factory()->create();
        $users->each(function ($user) use ($content) {
            ContentLike::create([
                "content_id" => $content->id,
                "user_id" => $user->id,
            ]);
        });
        $this->travel(1)->month();

        $this->assertTrue(
            Content::topLastMonth()
                ->first()
                ->is($content),
        );
    }
}
