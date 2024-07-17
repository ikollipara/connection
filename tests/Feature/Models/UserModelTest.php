<?php

namespace Tests\Feature\Models;

use App\Models\User;
use App\Models\UserProfile;
use App\ValueObjects\Avatar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class UserModelTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_create_user()
    {
        Event::fake([Registered::class]);
        $user = User::factory()->create();
        $this->assertDatabaseHas("users", ["email" => $user->email]);
        $this->assertEquals($user->email, trim(strtolower($user->email)));
        Event::assertDispatched(Registered::class);
    }

    public function test_user_full_name_is_correct()
    {
        $first_name = $this->faker->firstName();
        $last_name = $this->faker->lastName();
        $user = User::factory()->create([
            "first_name" => $first_name,
            "last_name" => $last_name,
        ]);
        $this->assertEquals("{$first_name} {$last_name}", $user->full_name);
    }

    public function test_user_can_have_default_avatar()
    {
        $user = User::factory()->create(["avatar" => ""]);
        $this->assertNotNull($user->avatar);
        $this->assertTrue(URL::isValidUrl($user->avatar));
    }

    public function test_user_can_have_custom_avatar_from_file()
    {
        Storage::fake("public");
        $avatar = UploadedFile::fake()->image("avatar.jpg");
        $avatar = Avatar::fromUploadedFile($avatar);
        Storage::disk("public")->assertExists($avatar->path());
        $user = User::factory()->create([
            "avatar" => $avatar,
        ]);
        $this->assertTrue($user->avatar->exists());
        $this->assertNotNull($user->avatar->url());
    }

    public function test_user_can_have_null_for_avatar()
    {
        Storage::fake("public");
        $avatar = null;
        $avatar = Avatar::fromUploadedFile($avatar);
        $user = User::factory()->create([
            "avatar" => $avatar,
        ]);
        $this->assertTrue(URL::isValidUrl($user->avatar->url()));
        $this->assertEquals($user->avatar->path(), "");
    }

    public function test_user_can_be_created_with_profile_and_settings()
    {
        $user = User::factory()->makeOne();
        $profile = UserProfile::factory()->makeOne();
        unset($profile["user_id"]);
        $user = User::createWithProfileAndSettings(
            array_merge($user->toArray(), $profile->toArray()),
        );

        $this->assertDatabaseHas("users", ["email" => $user->email]);
        $this->assertDatabaseHas("user_profiles", ["user_id" => $user->id]);
        $this->assertDatabaseHas("user_settings", ["user_id" => $user->id]);
        $this->assertEquals($user->profile->user_id, $user->id);
    }

    public function test_user_can_delete_their_avatar()
    {
        Storage::fake("public");
        $avatar = UploadedFile::fake()->image("avatar.jpg");
        $avatar = Avatar::fromUploadedFile($avatar);
        $user = User::factory()->create([
            "avatar" => $avatar,
        ]);
        $this->assertTrue($user->avatar->delete());
        $this->assertFalse($user->avatar->exists());
    }

    public function test_user_can_follow_another_user()
    {
        $user = User::factory()->create();
        $another_user = User::factory()->create();
        $user->followers()->attach($another_user);
        $this->assertTrue($user->followers->contains($another_user));
        $this->assertTrue($another_user->following->contains($user));
    }
}
