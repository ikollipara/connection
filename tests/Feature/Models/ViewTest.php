<?php

namespace Tests\Feature\Models;

use App\Models\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_a_view_can_be_created()
    {
        $view = View::factory()->create();
        $this->assertDatabaseCount("views", 1);
        $this->assertTrue($view->is(View::sole()));
    }

    public function test_a_view_belongs_to_a_user()
    {
        $view = View::factory()->create();
        $this->assertNotNull($view->user);
        $this->assertTrue($view->user()->exists());
    }

    public function test_a_view_belongs_to_content()
    {
        $view = View::factory()->create();
        $this->assertNotNull($view->content);
        $this->assertTrue($view->content()->exists());
    }

    public function test_a_view_can_be_scoped_to_this_month()
    {
        $this->travelTo(now()->subMonth());
        View::factory()->create();
        $this->travelBack();
        View::factory()->create();
        $this->assertEquals(1, View::thisMonth()->count());
    }

    public function test_a_view_can_be_scoped_to_last_month()
    {
        $this->travelTo(now()->subMonth());
        View::factory()->create();
        $this->travelBack();
        View::factory()->create();
        $this->assertEquals(1, View::lastMonth()->count());
    }
}
