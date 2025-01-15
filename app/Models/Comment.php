<?php

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
    use HasFactory, HasUuids, Likeable;

    protected $fillable = ['body', 'user_id', 'commentable_id', 'commentable_type', 'parent_id'];

    protected $casts = [];

    protected $with = ['children'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function parent(): ?BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    protected static function scopeRoot(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function isReply(): bool
    {
        return filled($this->parent_id);
    }
}
