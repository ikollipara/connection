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

    protected $attributes = [
        'bio' => '{"blocks": []}',
        'grades' => '[]',
    ];

    // Accessors and Mutators

    /**
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
            get: fn (): string => match ($this->is_preservice) {
                true => "$this->subject Pre-Service Teacher ($years)",
                false => "$this->subject Teacher ($years)",
            },
        );
    }

    /**
     * @return Attribute<Editor, Editor>
     */
    protected function bio(): Attribute
    {
        return Attribute::make(get: function (string $value): Editor {
            // @codeCoverageIgnoreStart
            if ($value[0] === '"') {
                $value = json_decode($value);
            }

            // @codeCoverageIgnoreEnd
            return Editor::fromJson($value);
        }, set: function (Editor $value): array {
            return ['bio' => $value->toJson()];
        })->withoutObjectCaching();
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

    /**
     * @return array{bio: 'array', grades: 'App\Enums\Grade:collection', is_preservice: 'boolean'}
     */
    protected function casts(): array
    {
        return [
            'bio' => 'array',
            'grades' => Grade::class.':collection',
            'is_preservice' => 'boolean',
        ];
    }
}
