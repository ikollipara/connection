<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Content>
     */
    public function entries()
    {
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
     * @param  \App\Models\Content|string  $content
     */
    public function hasEntry($content): bool
    {
        $content = $content instanceof Content ? $content->id : $content;

        return $this->entries()
            ->where('content_id', $content)
            ->exists();
    }

    protected function scopeWithHasEntry($query, $content = null)
    {
        if (is_null($content)) {
            return $query;
        }

        $content = $content instanceof Content ? $content->id : $content;

        return $query->addSelect([
            'has_entry' => $query->whereHas('entries', function ($query) use ($content) {
                $query->where('content_id', $content);
            })->select(['id']),
        ]);
    }
}