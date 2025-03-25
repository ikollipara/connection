<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\HasMetadata;
use App\Models\Concerns\Likeable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sluggable;
use App\Models\Concerns\Viewable;
use App\Models\Scopes\OrderByLikes;
use App\ValueObjects\Editor;
use DB;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Override;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event as ICalEvent;
use Throwable;

/**
 * @property Editor $description
 */
#[ScopedBy(OrderByLikes::class)]
class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    use HasMetadata;

    /** @use Likeable<self> */
    use Likeable;

    /** @use Searchable<self> */
    use Searchable;

    use Sluggable;

    /** @use Viewable<self> */
    use Viewable;

    protected $fillable = [
        'title',
        'description',
        'location',
        'user_id',
        'cloned_from',
        'metadata',
        'start',
        'end',
    ];

    protected $attributes = [
        'metadata' => '{"category": "material", "audience": "Teachers"}',
        'description' => '{"blocks": []}',
    ];

    /** @var list<string> */
    protected array $searchableColumns = ['title', 'description'];

    /** @var list<string> */
    protected array $filterableColumns = ['metadata->category', 'metadata->audience', 'metadata->languages', 'metadata->grades', 'metadata->standards', 'metadata->practices'];

    protected function scopeShouldBeSearchable(Builder $query): Builder
    {
        return $query->whereHas('days', fn (\Illuminate\Contracts\Database\Query\Builder $query) => $query->where('date', '>=', now()));
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<self, $this>
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(self::class, 'cloned_from');
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'attendees');
    }

    /**
     * @return HasMany<Day, $this>
     */
    public function days(): HasMany
    {
        return $this->hasMany(Day::class);
    }

    /**
     * @return MorphMany<Comment, $this>
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * @return Attribute<bool, null>
     */
    protected function isCloned(): Attribute
    {
        return Attribute::make(
            get: fn () => filled($this->cloned_from),
        );
    }

    /**
     * @return Attribute<bool, null>
     */
    protected function isSource(): Attribute
    {
        return Attribute::make(
            get: fn () => blank($this->cloned_from),
        );
    }

    /**
     * @return Attribute<Editor, Editor>
     */
    protected function description(): Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: function ($value): Editor {
            return Editor::fromJson($value);
        }, set: function (Editor $value) {
            return ['description' => $value->toJson()];
        })->withoutObjectCaching();
    }

    /**
     * @param  Builder  $query
     * @return Builder
     */
    protected function scopeIsAttending($query, ?User $user)
    {
        if (is_null($user)) {
            return $query;
        }

        return $query->whereHas('attendees', fn (Builder $query) => $query->where('user_id', $user->id))->orWhere('user_id', $user->id);
    }

    public function isMultiDay(): bool
    {
        return $this->days()->count() > 1;
    }

    /**
     * @param  list<string>|null  $except
     * @return static
     *
     * @throws Throwable
     */
    #[Override]
    public function replicate(?array $except = null)
    {
        return DB::transaction(function () use ($except) {
            $except = array_merge(['cloned_from'], $except ?? []);
            $replica = parent::replicate($except);

            $replica->cloned_from = $this->id;
            $replica->save();

            foreach ($this->days as $day) {
                $replica->days()->create($day->toArray());
            }

            return $replica;
        });
    }

    /**
     * @return Collection<int, ICalEvent>
     */
    public function toIcalEvent()
    {
        return $this->days->map->toIcalEvent();
    }

    public static function toICalCalendar(?User $user = null): Calendar
    {
        $calendar = match (true) {
            $user => Calendar::create("$user->name's conneCTION Calendar"),
            default => Calendar::create('conneCTION Calendar'),
        };
        $events = Event::query()->isAttending($user)->with('days')->get();
        foreach ($events as $event) {
            $event->days->each->setRelation('event', $event);
            foreach ($event->days as $day) {
                $calendar->event($day->toIcalEvent());
            }
        }

        return $calendar;
    }

    public function attendedBy(User $user): bool
    {
        return $this->attendees()->where('user_id', $user->id)->exists();
    }

    /**
     * @return array{description: 'array', start: 'datetime', end: 'datetime'}
     */
    protected function casts(): array
    {
        return [
            'description' => 'array',
            'start' => 'datetime',
            'end' => 'datetime',
        ];
    }
}

// /**
//  * Event
//  *
//  * An event is a scheduled activity that has a title, start date, and end date.
//  *
//  *
//  * @property int $id The unique identifier of the event.
//  * @property string $title The title of the event.
//  * @property string $location where the event is happening
//  * @property array $description The description of the event.
//  * @property string $user_id The unique identifier of the user who created the event.
//  * @property Carbon $start The date when the event starts.
//  * @property Carbon $end The date when the event ends.
//  * @property bool $is_all_day Indicates if the event is an all-day event.
//  * @property string $display_picture The display picture of the event.
//  * @property Carbon $created_at The date and time when the event was created.
//  * @property Carbon $updated_at The date and time when the event was last updated.
//  * @property Carbon $deleted_at The date and time when the event was deleted.
//  * @property-read string $description_text The description of the event as plain text.
//  * @property User $user The user who created the event.
//  * @property Attendee $attendees people who are attending the event
//  */
// class Event extends Model
// {
//     use HasFactory, SoftDeletes, HasMetadata;

//     protected $fillable = [
//         "title",
//         "location",
//         "description",
//         "user_id",
//         "start",
//         "end",
//         "is_all_day",
//         "display_picture",
//         "metadata",
//     ];

//     protected $casts = [
//         "description" => "array",
//         "location" => "string",
//         "start" => "datetime",
//         "end" => "datetime",
//         "is_all_day" => "boolean",
//     ];

//     protected $attributes = [
//         "metadata" => '{"category": "material", "audience": "Teachers"}',
//         "description" => '{"blocks": []}',
//     ];

//     protected static function booted()
//     {
//         //
//     }

//     /* ===== Overrides ===== */
//     public function getRouteKey()
//     {
//         return Str::slug($this->title).'--'.$this->getAttribute($this->getRouteKeyName());
//     }

//     public function resolveSoftDeletableRouteBinding($value, $field = null)
//     {
//         $id = last(explode('--', $value));

//         return parent::resolveSoftDeletableRouteBinding($id, $field);
//     }

//     /* ===== Relationships ===== */

//     /**
//      * Get the user who created the event.
//      *
//      * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
//      */
//     public function user()
//     {
//         return $this->belongsTo(User::class);
//     }

//     public function attendees()
//     {
//         return $this->hasMany(Attendee::class);
//     }

//     public function getAttendeeFor(User $user)
//     {
//         return $this->attendees()
//             ->where('user_id', $user->id)
//             ->first();
//     }

//     /* ===== Accessors and Mutators ===== */

//     /**
//      * Get the display picture of the event.
//      */
//     public function getDisplayPictureAttribute($value)
//     {
//         if (Storage::exists($value)) {
//             return Storage::url($value);
//         }

//         return false;
//     }

//     protected function getEndAttribute($value)
//     {
//         return Carbon::parse($value) ?? $this->start;
//     }

//     protected function getDescriptionAttribute($value)
//     {
//         // This is because of an issue with saving the JSON blob.
//         $parsedValue = json_decode($value, true);
//         if(is_string($parsedValue)) {
//             $value = $parsedValue;
//         }
//         return Editor::fromJson($value);
//     }

//     protected function setDescriptionAttribute(Editor $editor)
//     {
//         return $this->attributes["description"] = $editor->toJson();
//     }

//     // Methods

//     public function toFullCalendar($user)
//     {
//         $event = [
//             "title" => $this->title,
//             "start" => $this->start->format('Y-m-d\TH:i:s'),
//             "was_created_by_user" => $this->user()->is($user),
//             "user_id" => $this->user_id,
//             "id" => $this->id,
//             "allDay" => $this->is_all_day,
//         ];

//         if ($this->end) {
//             $event["end"] = $this->end->format('Y-m-d\TH:i:s');
//         }
//         // need to add for start and end times too

//         return $event;
//     }

//     public static function getICalFor(User $user): Calendar
//     {
//         $events = Event::query()
//             ->where("user_id", $user->id)
//             ->orWhereHas("attendees", function ($query) use ($user) {
//                 $query->where("user_id", $user->id);
//             })
//             ->lazy();

//         $calendar = Calendar::create("$user->name's conneCTION Calendar");

//         $events->each(function (Event $event) use ($calendar) {
//             $calendar->event(
//                 ICalEvent::create($event->title)
//                     ->organizer($event->user->email, $event->user->name)
//                     ->description($event->asPlainText("description"))
//                     ->startsAt($event->start)
//                     ->endsAt($event->end)
//                     ->alertMinutesBefore(30)
//                     ->address($event->location),
//             );
//         });

//         return $calendar;
//     }

//     public static function combineDateAndTime($date, $time = null)
//     {
//         $instance = Carbon::parse($date);
//         if($time) {
//             $time = Carbon::parse($time);
//             $instance->setTimeFrom($time);
//         }

//         return $instance;
//     }
// }
