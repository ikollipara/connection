<?php

use App\Mail\Contact;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

covers(Contact::class);

it('should create a valid contact', function () {
    $contact = new Contact(fake()->safeEmail(), fake()->word(), fake()->paragraphs(asText: true));

    expect($contact->envelope())->toBeInstanceOf(Envelope::class);
    expect($contact->content())->toBeInstanceOf(Content::class);
    expect($contact->content()->markdown)->not->toBeNull();
    expect($contact->attachments())->toBeEmpty();
});
