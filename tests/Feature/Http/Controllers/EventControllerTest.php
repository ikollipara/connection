<?php

use App\Http\Controllers\EventController;
use App\Models\Event;
use App\Models\User;

use function Pest\Laravel\actingAs;

covers(EventController::class);

it('should show all events', function () {
    Event::factory()->createMany(records: 10);
    /** @var User */
    $user = User::factory()->createOne();

    actingAs($user)
        ->get(route('events.index'))
        ->assertViewIs('events.index');
});


it('should show an event', function () {
    $event = Event::factory()->create();
    /** @var User */
    $user = User::factory()->createOne();

    actingAs($user)
        ->get(route('events.show', $event))
        ->assertViewIs('events.show')
        ->assertViewHas('event', $event);

    expect($event->views())->toEqual(1);
});
