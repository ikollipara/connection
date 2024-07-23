<?php

namespace Tests\Feature\Models;

use App\Enums\Status;
use App\Models\Content;
use App\Models\Likes\ContentLike;
use App\Models\User;
use App\ValueObjects\Metadata;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_content_can_be_created()
    {
        $content = Content::factory()->create();
        $this->assertDatabaseCount("content", 1);
        $this->assertTrue($content->is(Content::sole()));
    }

    public function test_content_can_be_converted_to_searchable_array()
    {
        $content = Content::factory()->create();
        $searchableArray = $content->toSearchableArray();
        $this->assertArrayHasKey("title", $searchableArray);
        $this->assertArrayHasKey("body", $searchableArray);
        $this->assertEquals($content->title, $searchableArray["title"]);
        $this->assertEquals($content->asPlainText("body"), $searchableArray["body"]);
    }

    public function test_content_should_be_searchable()
    {
        $draftContent = Content::factory()
            ->draft()
            ->create();
        $publishedContent = Content::factory()
            ->published()
            ->create();
        $archivedContent = Content::factory()->create();
        $archivedContent->delete();
        $this->assertFalse($draftContent->shouldBeSearchable());
        $this->assertTrue($publishedContent->shouldBeSearchable());
        $this->assertFalse($archivedContent->shouldBeSearchable());
    }

    public function test_content_should_get_the_correct_route_key()
    {
        $content = Content::factory()->create();
        $expected = str($content->title)->slug() . "--" . $content->id;
        $this->assertEquals($expected, $content->getRouteKey());
    }

    public function test_content_should_resolve_correctly_by_route_key()
    {
        $content = Content::factory()->create();
        $resolved = $content->resolveRouteBinding($content->getRouteKey());
        $this->assertEquals($content->id, $resolved->id);
    }

    public function test_content_should_resolve_correctly_when_soft_deleted()
    {
        $content = Content::factory()->create();
        $content->delete();
        $resolved = $content->resolveSoftDeletableRouteBinding($content->getRouteKey());
        $this->assertTrue($content->is($resolved));
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

    public function test_content_has_a_user()
    {
        $content = Content::factory()->create();
        $this->assertInstanceOf(User::class, $content->user);
    }

    public function test_content_has_likes()
    {
        $content = Content::factory()
            ->hasLikes(5)
            ->create();
        $this->assertDatabaseCount("content_likes", 5);
        $this->assertEquals(5, $content->likes->count());
    }

    public function test_content_has_views()
    {
        $content = Content::factory()
            ->hasViews(5)
            ->create();
        $this->assertDatabaseCount("views", 5);
        $this->assertEquals(5, $content->views->count());
    }

    public function test_content_can_belong_to_many_collections()
    {
        $content = Content::factory()->create();
        $collections = Content::factory()
            ->count(5)
            ->collection()
            ->create();
        $content->collections()->attach($collections);
        $this->assertEquals(5, $content->collections->count());
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
        $this->travelTo(now()->subMonth());
        Content::factory()
            ->count(2)
            ->published()
            ->create();
        $content = Content::factory()
            ->hasLikes(3)
            ->published()
            ->create();

        $this->travelBack();

        $this->assertTrue(
            Content::topLastMonth()
                ->first()
                ->is($content),
        );
    }

    public function test_content_can_normalize_search_constraints()
    {
        $normalized = Content::normalizeSearchConstraints([]);
        $this->assertArrayHasKey("type", $normalized);
        $this->assertArrayHasKey("categories", $normalized);
        $this->assertArrayHasKey("audiences", $normalized);
        $this->assertArrayHasKey("grades", $normalized);
        $this->assertArrayHasKey("standards", $normalized);
        $this->assertArrayHasKey("practices", $normalized);
        $this->assertArrayHasKey("languages", $normalized);
        $this->assertArrayHasKey("standard_groups", $normalized);
        $this->assertArrayHasKey("likes_count", $normalized);
        $this->assertArrayHasKey("views_count", $normalized);
    }

    public function test_content_can_be_scoped_by_search_constraints()
    {
        $contents = Content::factory()
            ->count(5)
            ->published()
            ->create();
        $normalized = Content::normalizeSearchConstraints([]);

        $this->assertEquals(5, Content::withSearchConstraints($normalized)->count());
    }
}
