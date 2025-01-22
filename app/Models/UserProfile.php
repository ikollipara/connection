<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Grade;
use App\Models\Concerns\Viewable;
use App\ValueObjects\Editor;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * \App\Models\UserProfile
 *
 * @property int $id
 * @property string $user_id
 * @property Editor $bio
 * @property bool $is_preservice
 * @property string $school
 * @property string $subject
 * @property-read string $short_title
 * @property \Illuminate\Support\Collection<\App\Enums\Grade> $grades
 * @property string $gender
 * @property int $years_of_experience
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User $user
 */
class UserProfile extends Model
{
    use HasFactory, Viewable;

    protected $guarded = [];

    protected $casts = [
        'bio' => 'array',
        'grades' => Grade::class . ':collection',
        'is_preservice' => 'boolean',
    ];

    protected $attributes = [
        'bio' => '{"blocks": []}',
        'grades' => '[]',
    ];

    // Accessors and Mutators

    protected function shortTitle(): Attribute
    {
        $years = match ($this->years_of_experience) {
            0 => 'First Year',
            1 => 'Second Year',
            default => "{$this->years_of_experience} Years",
        };

        return Attribute::make(
            get: fn() => match ($this->is_preservice) {
                true => "$this->subject Pre-Service Teacher ($years)",
                false => "$this->subject Teacher ($years)",
            },
        );
    }

    protected function getBioAttribute($value): Editor
    {
        // @codeCoverageIgnoreStart
        if ($value[0] === '"') {
            $value = json_decode($value);
        }
        // @codeCoverageIgnoreEnd

        return Editor::fromJson($value);
    }

    protected function setBioAttribute(Editor $value): void
    {
        $this->attributes['bio'] = $value->toJson();
    }

    // Relationships

    /**
     * Get the user that owns the profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
