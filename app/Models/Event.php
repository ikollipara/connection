<?php

namespace App\Models;

use App\Models\Concerns\HasMetadata;
use App\Models\Concerns\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event as ICalEvent;

/**
 * Event
 *
 * An event is a scheduled activity that has a title, start date, and end date.
 *
 *
 * @property int $id The unique identifier of the event.
 * @property string $title The title of the event.
 * @property string $location where the event is happening
 * @property array $description The description of the event.
 * @property string $user_id The unique identifier of the user who created the event.
 * @property Carbon $start_date The date when the event starts.
 * @property Carbon $end_date The date when the event ends.
 * @property Carbon $start_time The time when the event starts.
 * @property Carbon $end_time The time when the event ends.
 * @property bool $is_all_day Indicates if the event is an all-day event.
 * @property string $display_picture The display picture of the event.
 * @property Carbon $created_at The date and time when the event was created.
 * @property Carbon $updated_at The date and time when the event was last updated.
 * @property Carbon $deleted_at The date and time when the event was deleted.
 * @property-read string $description_text The description of the event as plain text.
 * @property User $user The user who created the event.
 * @property Attendee $attendees people who are attending the event
 */
class Event extends Model
{
    use HasFactory, SoftDeletes, HasMetadata, HasRichText;

    protected $fillable = [
        "title",
        "location",
        "description",
        "user_id",
        "start_date",
        "end_date",
        "start_time",
        "end_time",
        "is_all_day",
        "display_picture",
        "metadata",
    ];

    protected $casts = [
        "description" => "array",
        "location" => "string",
        "start_date" => "date",
        "end_date" => "date",
        "start_time" => "timestamp",
        "end_time" => "timestamp",
        "is_all_day" => "boolean",
    ];

    protected $attributes = [
        "metadata" => '{"category": "material", "audience": "Teachers"}',
    ];

    protected $rich_text_attributes = ["description"];

    protected static function booted()
    {
        //
    }

    /* ===== Overrides ===== */
    public function getRouteKey()
    {
        return Str::slug($this->title) . "--" . $this->getAttribute($this->getRouteKeyName());
    }

    public function resolveSoftDeletableRouteBinding($value, $field = null)
    {
        $id = last(explode("--", $value));
        return parent::resolveSoftDeletableRouteBinding($id, $field);
    }

    /* ===== Relationships ===== */

    /**
     * Get the user who created the event.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendees()
    {
        return $this->hasMany(Attendee::class);
    }

    public function getAttendeeFor(User $user)
    {
        return $this->attendees()
            ->where("user_id", $user->id)
            ->first();
    }

    /* ===== Accessors and Mutators ===== */

    /**
     * Get the display picture of the event.
     */
    public function getDisplayPictureAttribute($value)
    {
        if (Storage::exists($value)) {
            return Storage::url($value);
        }
        return false;
    }

    /**
     * Set the display picture of the event.
     */
    public function setDisplayPictureAttribute(UploadedFile $value)
    {
        $this->attributes["display_picture"] = $value->store("events", "public");
    }

    public function getEndDateAttribute($value)
    {
        return new Carbon($value) ?? $this->start_date;
    }

    // Methods

    public function toFullCalendar($user)
    {
        $event = [
            "title" => $this->title,
            "description" => $this->description,
            "start" => $this->start_date->toDateString(),
            "was_created_by_user" => $this->user()->is($user),
            "user_id" => $this->user_id,
            "id" => $this->id,
        ];

        if ($this->end_date) {
            $event["end"] = $this->end_date->addDay()->toDateString();
        }
        // need to add for start and end times too

        return $event;
    }

    public static function getICalFor(User $user): Calendar
    {
        $events = Event::query()
            ->where("user_id", $user->id)
            ->orWhereHas("attendees", function ($query) use ($user) {
                $query->where("user_id", $user->id);
            })
            ->lazy();

        $calendar = Calendar::create("$user->name's conneCTION Calendar");

        $events->each(function (Event $event) use ($calendar) {
            $calendar->event(
                ICalEvent::create($event->title)
                    ->organizer($event->user->email, $event->user->name)
                    ->description($event->asPlainText("description"))
                    ->startsAt($event->start_date)
                    ->endsAt($event->end_date)
                    ->alertMinutesBefore(30)
                    ->address($event->location),
            );
        });

        return $calendar;
    }
}
