<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Status;
use App\Models\Concerns\HasMetadata;
use App\Models\Concerns\Likeable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sluggable;
use App\Models\Concerns\Viewable;
use App\ValueObjects\Editor;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Parental\HasChildren;

class Content extends Model
{
    use HasChildren, HasFactory, HasMetadata, HasUuids, Likeable, Searchable, Sluggable, SoftDeletes, Viewable;

    protected $table = 'content';

    protected $childTypes = [
        'post' => Post::class,
        'collection' => ContentCollection::class,
    ];

    protected $fillable = ['title', 'body', 'metadata', 'published', 'user_id', 'type'];

    protected $casts = [
        'published' => 'boolean',
        'body' => 'array',
    ];

    protected $attributes = [
        'published' => false,
        'metadata' => '{"category": "material", "audience": "Teachers"}',
        'body' => '{"blocks": []}',
        'title' => '',
    ];

    protected $searchableColumns = ['title', 'body'];

    protected $filterableColumns = ['type', 'metadata->grades', 'metadata->standards', 'metadata->practices', 'metadata->languages', 'metadata->category', 'metadata->audience'];

    protected function scopeShouldBeSearchable(Builder $query)
    {
        return $query->where('published', true)->whereNull('deleted_at')->with('user');
    }

    // Accessors and Mutators

    public function getWasRecentlyPublishedAttribute()
    {
        return $this->published and $this->wasChanged('published');
    }

    public function getStatusAttribute()
    {
        if ($this->trashed()) {
            return Status::archived();
        }
        if ($this->published) {
            return Status::published();
        }

        return Status::draft();
    }

    protected function getBodyAttribute($value)
    {
        // TODO: Fix this hack
        // Some of the content is "doubly" stringified, so we need to
        // decode it twice. This is a temporary fix until we can
        // properly migrate the data.
        // @codeCoverageIgnoreStart
        if ($value[0] === '"') {
            $value = json_decode($value);
        }
        // @codeCoverageIgnoreEnd

        return Editor::fromJson($value);
    }

    protected function setBodyAttribute(Editor $value)
    {
        $this->attributes['body'] = $value->toJson();
    }

    // Relationships

    /**
     * Get the user that owns the content.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        /** @phpstan-ignore-next-line */
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany<ContentCollection, $this>
     */
    public function collections(): BelongsToMany
    {
        // Phpstan cannot handle custom pivot models
        /** @phpstan-ignore-next-line */
        return $this->belongsToMany(ContentCollection::class, 'entries', 'content_id', 'collection_id')->using(
            Entry::class,
        );
    }

    /**
     * Get all of the comments for the model.
     *
     * @return MorphMany<Comment, $this>
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // Scopes

    /**
     * Filter the query by status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<self>  $query
     * @param Status $status
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeStatus($query, Status $status)
    {
        if ($status->equals(Status::archived())) {
            return $query->onlyTrashed();
        } elseif (
            $status->equals(Status::published())
        ) {
            return $query->where('published', true);
        } elseif ($status->equals(Status::draft())) {
            return $query->where('published', false);
        }
    }

    /**
     * Filter the query by published status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<self>  $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeWherePublished($query)
    {
        return $query->where('published', true);
    }
}
