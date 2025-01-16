<?php

namespace Tests\Feature\Models;

use App\Enums\Status;
use App\Models\Content;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_content_can_be_created()
    {
        $content = Content::factory()->create();
        $this->assertDatabaseCount('content', 1);
        $this->assertTrue($content->is(Content::sole()));
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
        $this->assertTrue(Content::query()->shouldBeSearchable()->firstOrFail()->is($publishedContent));
    }

    public function test_content_should_get_the_correct_route_key()
    {
        $content = Content::factory()->create();
        $expected = str($content->title)->slug() . '--' . $content->id;
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
}
