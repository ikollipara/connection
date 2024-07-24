<?php

namespace Tests\Feature\Models;

use App\Models\Follower;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FollowerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_a_follower_can_be_created()
    {
        $follower = Follower::factory()->create();
        $this->assertDatabaseCount("followers", 1);
        $this->assertTrue($follower->is(Follower::sole()));
    }

    public function test_a_follower_belongs_to_a_follower()
    {
        $follower = Follower::factory()->create();
        $this->assertNotNull($follower->follower);
        $this->assertTrue($follower->follower()->exists());
    }

    public function test_a_follower_belongs_to_a_followed()
    {
        $follower = Follower::factory()->create();
        $this->assertNotNull($follower->followed);
        $this->assertTrue($follower->followed()->exists());
    }
}
