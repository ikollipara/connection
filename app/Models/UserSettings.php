<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * \App\Models\UserSettings
 *
 * @property int $id
 * @property string $user_id
 * @property bool $receive_weekly_digest
 * @property bool $receive_comment_notifications
 * @property bool $receive_new_follower_notifications
 * @property bool $receive_follower_notifications
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \App\Models\User $user
 */
class UserSettings extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['user'];

    protected $casts = [
        'receive_weekly_digest' => 'boolean',
        'receive_comment_notifications' => 'boolean',
        'receive_new_follower_notifications' => 'boolean',
        'receive_follower_notifications' => 'boolean',
    ];

    // Relationships

    /**
     * Get the user that owns the settings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
