<?php

namespace Tests\Feature\Controllers;

use App\Enums\Grade;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_get_user_create_page()
    {
        $response = $this->get(route("users.create"));
        $response->assertStatus(200);
        $response->assertViewIs("users.create");
    }

    public function test_create_preservice_user()
    {
        Storage::fake("public");
        $response = $this->post(route("users.store"), [
            "first_name" => $this->faker->firstName(),
            "last_name" => $this->faker->lastName(),
            "email" => $this->faker->unique()->safeEmail(),
            "grades" => $this->faker->randomElements(
                Grade::toValues(),
                $this->faker->numberBetween(1, 3),
            ),
            "school" => $this->faker->company(),
            "years_of_experience" => $this->faker->numberBetween(0, 10),
            "subject" => $this->faker->word(),
            "avatar" => UploadedFile::fake()->image("avatar.jpg"),
            "bio" => json_encode(["blocks" => []]),
            "gender" => "",
        ]);
        $response->assertRedirect(route("login.create"));
        $this->assertDatabaseCount("users", 1);
        $this->assertDatabaseCount("user_profiles", 1);
        $this->assertDatabaseCount("user_settings", 1);
        /** @var User */
        $user = User::first();
        Storage::disk("public")->assertExists($user->avatar->path());
        $response->assertRedirect(route("login.create"));
        $response->assertSessionHas(
            "success",
            __("Your account has been created. Please log in."),
        );
    }
}