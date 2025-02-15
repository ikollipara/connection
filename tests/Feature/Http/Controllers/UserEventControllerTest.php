<?php

use App\Http\Controllers\UserEventController;
use App\Models\Event;
use App\Models\User;
use App\Models\UserProfile;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

covers(UserEventController::class);

beforeEach(function () {
    /** @var User */
    $this->user = User::factory()->has(UserProfile::factory(), 'profile')->createOne();

    actingAs($this->user);
});

it('should return a list of all user events', function () {
    Event::factory(state: ['user_id' => $this->user])->createMany(records: 10);

    get(route('users.events.index', 'me'))
        ->assertOk()
        ->assertViewIs('users.events.index');
});

it('should return the create view', function () {
    get(route('users.events.create', 'me'))
        ->assertOk()
        ->assertViewIs('users.events.create');
});

it('should create a new event', function () {
    post(route('users.events.store', 'me'), [
        'title' => fake()->word(),
        'description' => '{"blocks": []}',
        'start' => '08:00',
        'end' => '09:00',
        'days' => [['date' => '2025-01-01']]
    ])
        ->assertRedirect()
        ->assertSessionMissing('error')
        ->assertSessionHasNoErrors();


    expect($this->user->events->count())->toEqual(1);
});

it('should create a new event (fail)', function () {
    $mock = DB::partialMock();
    $mock->shouldReceive('transaction')->andReturn([false, null]);
    post(route('users.events.store', 'me'), [
        'title' => fake()->word(),
        'description' => '{"blocks": []}',
        'start' => '08:00',
        'end' => '09:00',
        'days' => [['date' => '2025-01-01']]
    ])
        ->assertRedirect()
        ->assertSessionHas('error');
});

it('should show the edit page', function () {
    $event = Event::factory()->createOne(['user_id' => $this->user->id]);
    get(route('users.events.edit', ['me', $event]))
        ->assertOk()
        ->assertViewIs('users.events.edit');
});

it('should update an event', function () {
    $event = Event::factory()->createOne(['user_id' => $this->user->id, 'title' => 'mytitle']);
    put(route('users.events.update', ['me', $event->id]), [
        'title' => 'mytitle2',
        'description' => '{"blocks": []}',
        'start' => '08:00',
        'end' => '09:00',
        'days' => [['date' => '2025-01-01']]
    ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();
    $event->refresh();
    expect($event->title)->not->toEqual('mytitle');
});

it('should destroy an event', function () {
    $event = Event::factory()->createOne(['user_id' => $this->user->id]);
    delete(route('users.events.destroy', ['me', $event->id]))
        ->assertRedirect()
        ->assertSessionHas('success');
    assertDatabaseCount('events', 0);
});

it('should fail to destroy an event with attendees', function () {
    $event = Event::factory()->createOne(['user_id' => $this->user->id]);
    $event->attendees()->attach(User::factory()->createMany(records: 10));
    delete(route('users.events.destroy', ['me', $event->id]))
        ->assertRedirect()
        ->assertSessionHas('error');
});
