<?php

namespace App\Models;

use App\Enums\Grade;
use App\ValueObjects\Editor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @property-read string $bio_text
 * @property string $gender
 * @property int $years_of_experience
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User $user
 */
class UserProfile extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ["user"];
    protected $casts = [
        'bio' => 'array',
        'grades' => Grade::class.':collection',
        'is_preservice' => 'boolean',
    ];

    protected $attributes = [
        'bio' => '{"blocks": []}',
        'grades' => '[]',
    ];

    // Accessors and Mutators

    public function getShortTitleAttribute(): string
    {
        $year_str =
            $this->years_of_experience < 2
                ? '(First Year)'
                : "({$this->years_of_experience} Years)";
        $suffix = $this->is_preservice ? 'Pre-Service Teacher' : 'Teacher';

        return "{$this->subject} {$suffix} {$year_str}";
    }

    protected function getBioAttribute($value): Editor
    {
        return Editor::fromJson($value);
    }

    protected function setBioAttribute(Editor $editor): string
    {
        return $this->attributes["bio"] = $editor->toJson();
    }

    // Relationships

    /**
     * Get the user that owns the profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
