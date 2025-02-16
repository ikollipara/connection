<?php

use App\Http\Controllers\EventAttendeeController;
use App\Models\Event;
use App\Models\User;
use App\Models\UserProfile;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\post;

covers(EventAttendeeController::class);

beforeEach(function () {
    /** @var User */
    $this->user = User::factory()->has(UserProfile::factory(), 'profile')->createOne();
    $this->event = Event::factory()->createOne();
    actingAs($this->user);
});

it('should create an attendee', function () {
    post(route('events.attendees.store', $this->event), [
        'user_id' => $this->user->id,
    ])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect($this->event->attendees->count())->toEqual(1);
});

it('should destroy an attendee', function () {
    delete(route('events.attendees.destroy', [$this->event, $this->user]))
        ->assertRedirect()
        ->assertSessionHas('success');

    expect($this->event->attendees->count())->toEqual(0);
});
