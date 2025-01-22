<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Parental\HasParent;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<Content> $entries
 * @property-read int $entries_count
 */
class ContentCollection extends Content
{
    use HasFactory, HasParent;

    /**
     * Get all the entries for the post collection.
     *
     * @return BelongsToMany<Content, $this>
     */
    public function entries(): BelongsToMany
    {
        // Phpstan doesn't handle custom pivot models well.
        /** @phpstan-ignore-next-line */
        return $this->belongsToMany(
            Content::class,
            'entries',
            'collection_id',
            'content_id',
        )
            ->using(Entry::class)
            ->withPivot('id')
            ->withTimestamps();
    }

    /* ===== Methods ===== */

    /**
     * Check if a content is an entry of the post collection.
     *
     * @param  Content|string  $content
     */
    public function hasEntry($content): bool
    {
        $content = $content instanceof Content ? $content->id : $content;

        return $this->entries()
            ->where('content_id', $content)
            ->exists();
    }

    protected function scopeWithHasEntry(Builder $query, $content = null)
    {
        if (is_null($content)) {
            return $query;
        }

        $content = $content instanceof Content ? $content->id : $content;

        return $query->addSelect([
            'has_entry' => DB::table('entries')->where('content_id', $content)->whereColumn('collection_id', 'content.id')->selectRaw('1')->limit(1),
        ]);
    }
}
