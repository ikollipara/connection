<?php

namespace Tests\Feature\Models\Likes;

use App\Models\Likes\CommentLike;
use Tests\TestCase;

class CommentLikeTest extends TestCase
{
    public function test_comment_like_can_be_created()
    {
        $like = CommentLike::factory()->create();
        $this->assertDatabaseCount('comment_likes', 1);
        $this->assertTrue($like->is(CommentLike::sole()));
    }

    public function test_comment_like_belongs_to_a_user()
    {
        $like = CommentLike::factory()->create();
        $this->assertNotNull($like->user);
        $this->assertTrue($like->user()->exists());
    }

    public function test_comment_like_belongs_to_comment()
    {
        $like = CommentLike::factory()->create();
        $this->assertNotNull($like->comment);
        $this->assertTrue($like->comment()->exists());
    }
}
