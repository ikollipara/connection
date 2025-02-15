<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\IcalendarGenerator\Components\Event as ICalEvent;

class Day extends Model
{
    /** @use HasFactory<\Database\Factories\DayFactory> */
    use HasFactory;

    protected $fillable = [
        'event_id',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderByDesc('date');
        });
    }

    /**
     * The event the day belongs to.
     *
     * @return BelongsTo<Event, $this>
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function toIcalEvent(): ICalEvent
    {
        if (is_null($this->event)) throw new ModelNotFoundException("Day must be persisted with an event.");
        return ICalEvent::create($this->event->title)
            ->address($this->event->location)
            ->startsAt($this->date->setTimeFromTimeString($this->event->start->format('H:i')))
            ->endsAt($this->date->setTimeFromTimeString($this->event->end?->format('H:i') ?? $this->event->start->addMinutes(30)->format("H:i")))
            ->uniqueIdentifier(strval($this->id))
            ->url(route('events.show', $this->event));
    }
}
