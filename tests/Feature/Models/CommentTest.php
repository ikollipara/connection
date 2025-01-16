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
        $this->assertDatabaseCount('comments', 1);
        $this->assertTrue($comment->is(Comment::sole()));
    }

    public function test_comment_has_a_user()
    {
        $comment = Comment::factory()->create();
        $this->assertNotNull($comment->user);
        $this->assertTrue($comment->user()->exists());
    }

    public function test_comment_commentable()
    {
        /** @var Comment */
        $comment = Comment::factory()->create();
        $comment->commentable()->associate(Content::factory()->create());
        $this->assertNotNull($comment->commentable);
        $this->assertTrue($comment->commentable()->exists());
    }
}
