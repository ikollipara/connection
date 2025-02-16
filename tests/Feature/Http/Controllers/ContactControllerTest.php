<?php

use App\Http\Controllers\ContactController;
use App\Http\Requests\ContactRequest;
use App\Mail\Contact;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

covers(ContactController::class, ContactRequest::class, Contact::class);

it('should display the contact form', function () {
    $response = get(route('contact'));

    $response->assertOk();
});

it('should create an email to the maintainer', function () {
    $data = [
        'email' => fake()->safeEmail(),
        'subject' => fake()->word(),
        'message' => fake()->paragraphs(asText: true),
    ];

    Mail::fake();
    $response = post(route('contact'), $data);
    $response->assertRedirect(route('contact'));

    Mail::assertQueued(Contact::class);
});

it('should fail to create an email to the maintainer', function () {
    $data = [
        'subject' => fake()->word(),
        'message' => fake()->paragraphs(asText: true),
    ];

    Mail::fake();
    $response = post(route('contact'), $data);
    $response->assertRedirect(route('contact'));

    Mail::assertNothingQueued();
});
