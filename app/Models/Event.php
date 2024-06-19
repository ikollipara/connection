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

/**
 * Event
 *
 * An event is a scheduled activity that has a title, start date, and end date.
 *
 *
 * @property int $id The unique identifier of the event.
 * @property string $title The title of the event.
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
 */
class Event extends Model
{
    use HasFactory, SoftDeletes, HasMetadata, HasRichText;

    protected $fillable = [
        "title",
        "description",
        "user_id",
        "start_date",
        "end_date",
        "start_time",
        "end_time",
        "is_all_day",
        "display_picture",
    ];

    protected $casts = [
        "description" => "array",
        "start_date" => "date",
        "end_date" => "date",
        "start_time" => "time",
        "end_time" => "time",
        "is_all_day" => "boolean",
    ];

    protected $rich_text_attributes = ["description"];

    protected static function booted()
    {
        //
    }

    /* ===== Overrides ===== */
    public function getRouteKey()
    {
        return Str::slug($this->title) .
            "--" .
            $this->getAttribute($this->getRouteKeyName());
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
        $this->attributes["display_picture"] = $value->store(
            "events",
            "public",
        );
    }
}
