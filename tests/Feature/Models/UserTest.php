<?php

namespace Tests\Feature\Models;

use App\Mail\Survey;
use App\Models\User;
use App\Models\UserProfile;
use App\ValueObjects\Avatar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_can_be_created()
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas("users", [
            "email" => str($user->email)
                ->trim()
                ->lower()
                ->__toString(),
        ]);
    }

    public function test_when_a_user_is_created_a_registered_event_is_dispatched()
    {
        Event::fake([Registered::class]);
        $user = User::factory()->create();
        Event::assertDispatched(Registered::class);
    }

    public function test_when_user_is_saved_as_consented_a_mail_notification_is_sent()
    {
        Mail::fake();
        $user = User::factory()->create(["consented" => true]);
        Mail::assertQueued(Survey::class);
    }

    public function test_user_route_key_is_correct()
    {
        $user = User::factory()->create();
        $expected = "@" . str($user->full_name)->slug("-") . "--" . $user->id;
        $this->assertEquals($expected, $user->getRouteKey());
    }

    public function test_user_can_be_correctly_resolved_by_route_key()
    {
        $user = User::factory()->create();
        $resolved = $user->resolveRouteBinding($user->getRouteKey());
        $this->assertEquals($user->id, $resolved->id);
    }

    public function test_user_is_resolved_to_authed_when_me_is_passed_as_route_key()
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actingAs($user);

        $resolved = $user->resolveRouteBinding("me");

        $this->assertEquals($user->id, $resolved->id);
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

    public function test_user_avatar_will_return_default_if_empty()
    {
        $user = User::factory()->create(["avatar" => ""]);
        $this->assertNotNull($user->avatar);
        $this->assertTrue(URL::isValidUrl($user->avatar));
    }

    public function test_user_avatar_can_be_set_from_uploaded_file()
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

    public function test_user_avatar_can_be_null()
    {
        Storage::fake("public");
        $user = User::factory()->create([
            "avatar" => Avatar::fromUploadedFile(null),
        ]);
        $this->assertTrue(URL::isValidUrl($user->avatar->url()));
        $this->assertEquals($user->avatar->path(), "");
    }

    public function test_user_can_have_many_followers()
    {
        $user = User::factory()->create();
        $followers = User::factory()
            ->count(5)
            ->create();
        $user->followers()->attach($followers);
        $this->assertEquals(5, $user->followers->count());
    }

    public function test_user_can_follow_many_users()
    {
        $user = User::factory()->create();
        $following = User::factory()
            ->count(5)
            ->create();
        $user->following()->attach($following);
        $this->assertEquals(5, $user->following->count());
    }

    public function test_user_can_have_one_setting()
    {
        $user = User::factory()
            ->hasSettings()
            ->create();
        $this->assertDatabaseHas("user_settings", ["user_id" => $user->id]);
        $this->assertNotNull($user->settings);
    }

    public function test_user_can_have_one_profile()
    {
        $user = User::factory()
            ->hasProfile()
            ->create();
        $this->assertDatabaseHas("user_profiles", ["user_id" => $user->id]);
        $this->assertNotNull($user->profile);
    }

    public function test_user_can_have_many_content()
    {
        $user = User::factory()
            ->hasContent(5)
            ->create();
        $this->assertEquals(5, $user->content->count());
    }

    public function test_user_can_have_many_posts()
    {
        $user = User::factory()
            ->hasPosts(5)
            ->create();
        $this->assertEquals(5, $user->posts->count());
    }

    public function test_user_can_have_many_collections()
    {
        $user = User::factory()
            ->hasCollections(5)
            ->create();
        $this->assertEquals(5, $user->collections->count());
    }

    public function test_user_can_have_many_comments()
    {
        $user = User::factory()
            ->hasComments(5)
            ->create();
        $this->assertEquals(5, $user->comments->count());
    }

    public function test_user_can_have_many_searches()
    {
        $user = User::factory()->create();
        foreach (range(1, 5) as $i) {
            $user->searches()->create([
                "search_params" => [],
            ]);
        }
        $this->assertEquals(5, $user->searches->count());
    }

    public function test_user_can_be_created_with_profile_and_settings()
    {
        $user = User::factory()->makeOne();
        $profile = UserProfile::factory()->makeOne();
        unset($profile["user_id"]);
        $user = User::createWithProfileAndSettings(array_merge($user->toArray(), $profile->toArray()));

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
