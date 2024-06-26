<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * \App\Models\View
 * @property int $id
 * @property string $user_id
 * @property string $content_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Content $content
 * @property \App\Models\User $user
 */
class View extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = ["user_id", "content_id"];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        "created_at" => "datetime",
        "updated_at" => "datetime",
    ];

    // Relationships

    /**
     * Get the content that the view belongs to.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Content>
     */
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    /**
     * Get the user that viewed the content.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes

    public function scopeThisMonth($query)
    {
        return $query->whereBetween("created_at", [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ]);
    }

    public function scopeLastMonth($query)
    {
        return $query->whereBetween("created_at", [
            now()
                ->subMonth()
                ->startOfMonth(),
            now()
                ->subMonth()
                ->endOfMonth(),
        ]);
    }
}
