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
use Illuminate\Database\Eloquent\Casts\Attribute;
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
    use HasChildren;

    /** @use HasFactory<\Database\Factories\ContentFactory> */
    use HasFactory;

    use HasMetadata, HasUuids;

    /** @use Likeable<self> */
    use Likeable;

    /** @use Searchable<self> */
    use Searchable;

    use Sluggable, SoftDeletes;

    /** @use Viewable<self> */
    use Viewable;

    protected $table = 'content';

    /** @phpstan-ignore-next-line */
    protected $childTypes = [
        'post' => Post::class,
        'collection' => ContentCollection::class,
    ];

    protected $fillable = ['title', 'body', 'metadata', 'published', 'user_id', 'type'];

    protected $attributes = [
        'published' => false,
        'metadata' => '{"category": "material", "audience": "Teachers"}',
        'body' => '{"blocks": []}',
        'title' => '',
    ];

    /** @var list<string> */
    protected array $searchableColumns = ['title', 'body'];

    /** @var list<string> */
    protected array $filterableColumns = ['type', 'metadata->grades', 'metadata->standards', 'metadata->practices', 'metadata->languages', 'metadata->category', 'metadata->audience'];

    protected function scopeShouldBeSearchable(Builder $query): Builder
    {
        return $query->where('published', true)->whereNull('deleted_at')->with('user');
    }

    /**
     * @return Attribute<bool, null>
     */
    protected function wasRecentlyPublished(): Attribute
    {
        return Attribute::make(get: function (): bool {
            return $this->published and $this->wasChanged('published');
        });
    }

    /**
     * @return Attribute<Status, null>
     */
    protected function status(): Attribute
    {
        return Attribute::make(get: function (): Status {
            if ($this->trashed()) {
                return Status::archived();
            }
            if ($this->published) {
                return Status::published();
            }

            return Status::draft();
        })->withoutObjectCaching();
    }

    /**
     * @return Attribute<Editor, Editor>
     */
    protected function body(): Attribute
    {
        return Attribute::make(get: function (string $value): Editor {
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
        }, set: function (Editor $value): array {
            return ['body' => $value->toJson()];
        })->withoutObjectCaching();
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
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeStatus($query, Status $status)
    {
        if ($status->equals(Status::archived())) {
            $query->onlyTrashed();
        } elseif (
            $status->equals(Status::published())
        ) {
            $query->where('published', true);
        } elseif ($status->equals(Status::draft())) {
            $query->where('published', false);
        }

        return $query;
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

    /**
     * @return array{published: 'boolean', body: 'array'}
     */
    protected function casts(): array
    {
        return [
            'published' => 'boolean',
            'body' => 'array',
        ];
    }
}
