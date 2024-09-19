<?php
namespace App\Http\Requests;
use App\Http\Requests\LoginRequest;
use function Pest\Laravel\post;
use Illuminate\Support\Facades\Mail;
#use factory for users
Use database\factories\UserFactory;


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

    $reponse = post('/login', [
        'email' => UserFactory::new()->create()->email #should pass once we get a valid email
    ]);

    $reponse->assertRedirect();
    $reponse->assertSessionHasNoErrors();
    Mail::assertQueuedCount(1);
});

it('login with invalid email', function () {
    Mail::fake();

    $reponse = post('/login', [
        'email' => 'sampleemail@sampleemail.com'
    ]);

    $reponse->assertRedirect();
    $reponse->assertSessionHasErrors();
    $reponse->assertSessionHasErrors('email');
    Mail::assertQueuedCount(0);
});

it('login with valid email but not in the DB', function () {
    Mail::fake();

    $reponse = post('/login', [
        'email' => 'sampleemail@sampleemail.com'
    ]);

    $reponse->assertRedirect();
    $reponse->assertSessionHasErrors();
    Mail::assertQueuedCount(0);
});
