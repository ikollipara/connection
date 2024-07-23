<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Content;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_comment_can_be_created()
    {
        $comment = Comment::factory()->create();
        $this->assertDatabaseCount("comments", 1);
        $this->assertTrue($comment->is(Comment::sole()));
    }

    public function test_comment_has_a_user()
    {
        $comment = Comment::factory()->create();
        $this->assertNotNull($comment->user);
        $this->assertTrue($comment->user()->exists());
    }

    public function test_comment_has_likes()
    {
        $comment = Comment::factory()
            ->hasLikes(5)
            ->create();
        $this->assertNotNull($comment->likes);
        $this->assertEquals(5, $comment->likes->count());
    }

    public function test_comment_commentable()
    {
        /** @var Comment */
        $comment = Comment::factory()->create();
        $comment->commentable()->associate(Content::factory()->create());
        $this->assertNotNull($comment->commentable);
        $this->assertTrue($comment->commentable()->exists());
    }

    public function test_comments_can_be_scoped_to_this_month()
    {
        $this->travelTo(now()->subMonth());
        Comment::factory()->create();
        $this->travelBack();
        Comment::factory()->create();
        $this->assertEquals(1, Comment::thisMonth()->count());
    }

    public function test_comments_can_be_scoped_to_last_month()
    {
        $this->travelTo(now()->subMonth());
        Comment::factory()->create();
        $this->travelBack();
        Comment::factory()->create();
        $this->assertEquals(1, Comment::lastMonth()->count());
    }
}
