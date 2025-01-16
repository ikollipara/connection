<?php

namespace Tests\Feature\Models;

use App\Enums\Grade;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_user_profile()
    {
        /** @var UserProfile */
        $userProfile = UserProfile::factory()->createOne();

        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $userProfile->user_id,
        ]);
        $this->assertDatabaseCount('user_profiles', 1);
        $this->assertContainsOnlyInstancesOf(Grade::class, $userProfile->grades);
    }

    public function test_can_get_short_title()
    {
        $userProfile = UserProfile::factory()->create([
            'subject' => 'Math',
            'is_preservice' => false,
            'years_of_experience' => 3,
        ]);
        $this->assertEquals(
            'Math Teacher (3 Years)',
            $userProfile->short_title,
        );

        $userProfile = UserProfile::factory()->create([
            'subject' => 'Science',
            'is_preservice' => true,
            'years_of_experience' => 0,
        ]);
        $this->assertEquals(
            'Science Pre-Service Teacher (First Year)',
            $userProfile->short_title,
        );

        $userProfile = UserProfile::factory()->create([
            'subject' => 'English',
            'is_preservice' => false,
            'years_of_experience' => 0,
        ]);
        $this->assertEquals(
            'English Teacher (First Year)',
            $userProfile->short_title,
        );
    }
}
