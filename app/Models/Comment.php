<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\Likeable;
use App\Models\Scopes\OrderByLikes;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[ScopedBy(OrderByLikes::class)]
class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;
    use HasUuids;
    /** @use Likeable<self> */
    use Likeable;

    protected $fillable = ['body', 'user_id', 'commentable_id', 'commentable_type', 'parent_id'];

    protected $with = ['children'];

    /**
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     *
     * @return MorphTo<Model, $this>
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     *
     * @return BelongsTo<self, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    /**
     *
     * @return HasMany<self, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
     *
     * @param Builder<self> $query
     * @return Builder<self>
     */
    protected static function scopeRoot(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function isReply(): bool
    {
        return filled($this->parent_id);
    }
    protected function casts(): array
    {
        return [];
    }
}
