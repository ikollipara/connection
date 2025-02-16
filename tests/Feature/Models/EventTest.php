<?php

namespace Tests\Feature\Models;

use App\Models\Day;
use App\Models\Event;
use App\Models\User;
use App\ValueObjects\Editor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event as ICalEvent;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    protected Event $event;

    protected function setUp(): void
    {
        parent::setUp();
        $this->event = Event::factory()->has(Day::factory(3))->createOne();
    }

    public function test_event_can_be_created()
    {

        $this->assertDatabaseCount('events', 1);
        $this->assertTrue(Event::sole()->is($this->event));
    }

    public function test_event_has_user()
    {

        $this->assertInstanceOf(User::class, $this->event->user);
    }

    public function test_event_has_optional_source()
    {

        $this->assertNull($this->event->source);
    }

    public function test_event_has_attendees()
    {
        $this->assertCount(0, $this->event->attendees);
    }

    public function test_event_has_days()
    {
        $this->assertCount(3, $this->event->days);
    }

    public function test_event_has_comments()
    {
        $this->assertCount(0, $this->event->comments);
    }

    public function test_event_is_cloned()
    {
        $this->assertFalse($this->event->is_cloned);
    }

    public function test_event_is_source()
    {
        $this->assertTrue($this->event->is_source);
    }

    public function test_event_description()
    {
        $this->assertInstanceOf(Editor::class, $this->event->description);
    }

    public function test_event_description__set()
    {
        $this->event->description = new Editor(['time' => now()->valueOf(), 'blocks' => [], 'version' => '2.8.1']);
        $this->assertInstanceOf(Editor::class, $this->event->description);
    }

    public function test_event_scope_is_attending()
    {
        $this->assertCount(0, Event::query()->isAttending(User::factory()->createOne())->get());
    }

    public function test_is_multiday()
    {
        $this->assertTrue($this->event->isMultiDay());
    }

    public function test_replicate()
    {
        $this->event->replicate();

        $this->assertDatabaseCount('events', 2);
    }

    public function test_event_to_ical()
    {
        $calendar = Event::toICalCalendar();

        $this->assertInstanceOf(Calendar::class, $calendar);
    }

    public function test_attended_by()
    {
        $this->assertFalse($this->event->attendedBy(User::factory()->createOne()));
    }

    public function test_to_ical_event()
    {
        $result = $this->event->toIcalEvent();
        $this->assertCount(3, $result);
        $result->each(fn ($r) => $this->assertInstanceOf(ICalEvent::class, $r));
    }
}
