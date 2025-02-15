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

class UserProfile extends Model
{
    /** @use HasFactory<\Database\Factories\UserProfileFactory> */
    use HasFactory;
    /** @use Viewable<self> */
    use Viewable;

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

    /**
     *
     * @return Attribute<string, null>
     */
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

    /**
     * @param mixed $value
     * @return Editor
     */
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
