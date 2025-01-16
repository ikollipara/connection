<?php

namespace Tests\Feature\Controllers;

use App\Enums\Grade;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function test_create_user()
    {
        $this->markTestSkipped('Needs to be moved to RegisteredUserControllerTest');
        Storage::fake('public');
        $response = $this->post(route('users.store'), [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'grades' => $this->faker->randomElements(Grade::toValues(), $this->faker->numberBetween(1, 3)),
            'school' => $this->faker->company(),
            'years_of_experience' => $this->faker->numberBetween(0, 10),
            'subject' => $this->faker->word(),
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
            'bio' => json_encode(['blocks' => []]),
            'gender' => '',
        ]);
        $response->assertRedirect(route('login.create'));
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('user_profiles', 1);
        $this->assertDatabaseCount('user_settings', 1);
        /** @var User */
        $user = User::first();
        Storage::disk('public')->assertExists($user->avatar->path());
        $response->assertRedirect(route('login.create'));
        $response->assertSessionHas('success', __('Your account has been created. Please log in.'));
    }

    public function test_delete_user()
    {
        $this->markTestSkipped("Delete needs to be reimplmented");
        $user = User::factory()
            ->hasProfile()
            ->hasSettings()
            ->create();
        $response = $this->actingAs($user)->delete(route('users.destroy', $user));
        $response->assertRedirect(route('users.create'));
        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('user_profiles', 0);
        $this->assertDatabaseCount('user_settings', 0);
    }

    public function test_delete_user_fail()
    {
        $this->markTestSkipped("Delete needs to be reimplmented");
        $user = User::factory()
            ->hasProfile()
            ->hasSettings()
            ->create();
        $response = $this->actingAs($user)->delete(route('users.destroy', $user));
        $response->assertRedirect(route('users.create'));
        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('user_profiles', 0);
        $this->assertDatabaseCount('user_settings', 0);
    }
}
