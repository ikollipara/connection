<?php

use App\Http\Controllers\EventICalController;
use App\Models\Event;

use function Pest\Laravel\get;

covers(EventICalController::class);


it('should return a calendar response', function () {
    Event::factory()->createMany(records: 10);

    $response = get(route('events.ical'));

    $response->assertOk();
    $response->assertHeader('Content-Type', 'text/calendar; charset=UTF-8');
});
