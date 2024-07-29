<?php

namespace App\Models;

use App\Models\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['body', 'user_id', 'commentable_id', 'commentable_type'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * Get the user that owns the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, self>
     */
    public function user()
    {
        /** @phpstan-ignore-next-line */
        return $this->belongsTo(User::class);
    }

    /**
     * Get the likes for the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Likes\CommentLike>
     */
    public function likes()
    {
        return $this->hasMany(Likes\CommentLike::class);
    }

    /**
     * Get the post or post collection that owns the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo<Content>
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    // Scopes

    public function scopeThisMonth($query)
    {
        return $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
    }

    public function scopeLastMonth($query)
    {
        return $query->whereBetween('created_at', [
            now()
                ->subMonth()
                ->startOfMonth(),
            now()
                ->subMonth()
                ->endOfMonth(),
        ]);
    }
}
