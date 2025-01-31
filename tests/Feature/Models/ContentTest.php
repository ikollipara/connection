<?php

namespace Tests\Feature\Models;

use App\Enums\Status;
use App\Models\Comment;
use App\Models\Content;
use App\Models\User;
use App\ValueObjects\Editor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
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

    public function test_was_recently_published()
    {
        $this->markTestSkipped("Flaky");
        /** @var Content */
        $content = Content::factory()->createOne();

        $content->published = true;
        $content->save();

        $this->assertTrue($content->was_recently_published);
    }

    public function test_body_is_instance_of_editor()
    {
        /** @var Content */
        $content = Content::factory()->createOne();

        $this->assertInstanceOf(Editor::class, $content->body);
    }

    public function test_content_has_comments()
    {
        /** @var Content */
        $content = Content::factory()->createOne();

        $comments = Comment::factory(count: 3)->createMany();
        foreach ($comments as $comment) {
            $content->comments->add($comment);
        }

        $this->assertCount(3, $content->comments);
    }

    // Viewable Tests
    public function test_views()
    {
        /** @var Content */
        $content = Content::factory()->createOne();

        $this->assertEquals(0, $content->views());
        Cache::clear();
    }

    public function test_view()
    {
        /** @var Content */
        $content = Content::factory()->createOne();
        $this->actingAs($content->user);

        $content->view();

        $this->assertEquals(1, $content->views());
    }

    public function test_order_by_views()
    {
        /** @var Content */
        $content1 = Content::factory()->createOne();
        $content2 = Content::factory()->createOne();
        $this->actingAs($content1->user);

        $content1->view();

        $result = Content::query()->orderByViews()->get();

        $this->assertTrue($result[0]->is($content1));
    }

    public function test_has_views_count()
    {
        /** @var Content */
        $content1 = Content::factory()->createOne();
        $this->actingAs($content1->user);

        $content1->view();

        $result = Content::query()->hasViewsCount(1)->count();

        $this->assertEquals(1, $result);
    }

    // Likeable tests
    public function test_likes()
    {
        /** @var Content */
        $content = Content::factory()->createOne();

        $this->assertEquals(0, $content->likes());
        Cache::clear();
    }

    public function test_like()
    {
        /** @var Content */
        $content = Content::factory()->createOne();
        $this->actingAs($content->user);

        $content->like();

        $this->assertEquals(1, $content->likes());
    }

    public function test_order_by_likes()
    {
        /** @var Content */
        $content1 = Content::factory()->createOne();
        $content2 = Content::factory()->createOne();
        $this->actingAs($content1->user);

        $content1->like();

        $result = Content::query()->orderBylikes()->get();

        $this->assertTrue($result[0]->is($content1));
    }

    public function test_has_likes_count()
    {
        /** @var Content */
        $content1 = Content::factory()->createOne();
        $this->actingAs($content1->user);

        $content1->like();

        $result = Content::query()->hasLikesCount(1)->count();

        $this->assertEquals(1, $result);
    }

    // Searchable Tests
    public function test_filter_by()
    {
        /** @var Content */
        $content = Content::factory()->published()->createOne();

        $result = Content::query()->shouldBeSearchable()->search($content->title)->filterBy(['metadata->category' => $content->metadata->category->value, 'views' => 0, 'likes' => 0])->count();

        $this->assertEquals(1, $result);
    }
}
