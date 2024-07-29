<?php

namespace Tests\Feature\Models;

use App\Models\FrequentlyAskedQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class FrequentlyAskedQuestionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_FAQ_can_be_created()
    {
        $frequentlyAskedQuestion = FrequentlyAskedQuestion::factory()->create();
        $this->assertDatabaseCount('frequently_asked_questions', 1);
        $this->assertTrue($frequentlyAskedQuestion->is(FrequentlyAskedQuestion::sole()));
    }

    public function test_FAQ_belongs_to_user()
    {
        $frequentlyAskedQuestion = FrequentlyAskedQuestion::factory()->create();
        $this->assertNotNull($frequentlyAskedQuestion->user);
        $this->assertTrue($frequentlyAskedQuestion->user()->exists());
    }

    public function test_FAQ_can_be_scoped_to_unanswered()
    {
        Notification::fake();
        $faq = FrequentlyAskedQuestion::factory()
            ->count(5)
            ->create();
        $faq->first()->answerQuestion($this->faker->paragraph());
        $this->assertEquals(4, FrequentlyAskedQuestion::unanswered()->count());
    }

    public function test_FAQ_can_be_answered()
    {
        Notification::fake();
        $faq = FrequentlyAskedQuestion::factory()->create();
        $faq->answerQuestion($this->faker->paragraph());
        $this->assertEquals(1, FrequentlyAskedQuestion::answered()->count());
    }

    public function test_FAQ_can_be_searched()
    {
        $faq = FrequentlyAskedQuestion::factory()->create();
        $this->assertNotEmpty(FrequentlyAskedQuestion::search($faq->title)->get());
    }

    public function test_FAQ_has_rating()
    {
        $faq = FrequentlyAskedQuestion::factory()->create();
        $this->assertEquals(0.0, $faq->rating);

        $faq->upvote();
        $this->assertEquals(100.0, $faq->rating);
        $faq->downvote();
        $this->assertEquals(50.0, $faq->rating);
    }

    public function test_FAQ_has_is_answered_attribute()
    {
        $faq = FrequentlyAskedQuestion::factory()->create();
        $this->assertFalse($faq->is_answered);
        $faq->answerQuestion($this->faker->paragraph());
        $this->assertTrue($faq->is_answered);
    }

    public function test_FAQ_has_content_excerpt()
    {
        $faq = FrequentlyAskedQuestion::factory()->create();
        $this->assertNotEmpty($faq->content_excerpt);
    }

    public function test_FAQ_has_content_excerpt_limit()
    {
        $faq = FrequentlyAskedQuestion::factory()->create();

        // 20 characters + 3 dots
        $this->assertLessThanOrEqual(20 + 3, strlen($faq->content_excerpt));
    }

    public function test_FAQ_has_answer_excerpt()
    {
        $faq = FrequentlyAskedQuestion::factory()->create();
        $faq->answerQuestion($this->faker->paragraph());
        $this->assertNotEmpty($faq->answer_excerpt);
    }

    public function test_FAQ_has_answer_excerpt_limit()
    {
        $faq = FrequentlyAskedQuestion::factory()->create();
        $faq->answerQuestion($this->faker->paragraph());
        $this->assertLessThanOrEqual(20 + 3, strlen($faq->answer_excerpt));
    }

    public function test_FAQ_has_answer_excerpt_when_null()
    {
        $faq = FrequentlyAskedQuestion::factory()->create();
        $this->assertEmpty($faq->answer_excerpt);
    }

    public function test_FAQ_has_route_key()
    {
        $faq = FrequentlyAskedQuestion::factory()->create();
        $expected = str($faq->title)->slug().'-'.$faq->id;
        $this->assertEquals($expected, $faq->getRouteKey());
    }

    public function test_FAQ_can_be_resolved_by_route_key()
    {
        $faq = FrequentlyAskedQuestion::factory()->create();
        $resolved = $faq->resolveRouteBinding($faq->getRouteKey());
        $this->assertTrue($faq->is($resolved));
    }

    public function test_FAQ_can_be_upvoted()
    {
        $faq = FrequentlyAskedQuestion::factory()->create();
        $faq->upvote();
        $this->assertEquals(1, $faq->history->count());
    }

    public function test_FAQ_can_be_downvoted()
    {
        $faq = FrequentlyAskedQuestion::factory()->create();
        $faq->downvote();
        $this->assertEquals(1, $faq->history->count());
    }
}
