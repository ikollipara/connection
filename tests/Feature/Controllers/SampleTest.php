<?php
namespace App\Http\Requests;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use function Pest\Laravel\post;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;


uses(RefreshDatabase::class);
uses()->group('sample');



it('login request test with no email', function () {
    $request = new LoginRequest();
    $rules = $request->rules();
    $messages = $request->messages();

    expect($rules)->toBeArray();
    expect($rules['email'])->toBe('email|required|exists:users,email');

    expect($messages)->toBeArray();
    expect($messages['email.exists'])->toBe('The email you entered does not exist.');

});

it('login request test with email but not valid', function () {
    $request = new LoginRequest();
    $request->request->set('email', 'test@example.com');
    $rules = $request->rules();
    $messages = $request->messages();

    expect($rules)->toBeArray();
    expect($rules['email'])->toBe('email|required|exists:users,email');

    expect($messages)->toBeArray();
    expect($messages['email.email'])->toBe('Please enter a valid email address.');
});

it('login with valid email', function () {
    Mail::fake();

    // Use the factory to create a user
    $user = User::factory()->create();
    $this->assertDatabaseHas('users', [
        'email' => $user->email,
    ]);
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect('/login/create');
    $response->assertSessionHasNoErrors();
    Mail::assertQueuedCount(1);
});

it('login with invalid email', function () {
    Mail::fake();

    $response = post('/login', [
        'email' => 'sampleemail@sampleemail.com'
    ]);

    // $reponse->assertRedirect();
    $response->assertRedirect();
    $response->assertSessionHasErrors();
    $response->assertSessionHasErrors('email');
    Mail::assertQueuedCount(0);
});
