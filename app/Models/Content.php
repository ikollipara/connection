<?php

namespace App\Models;

use App\Enums\Standard;
use App\Enums\StandardGroup;
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
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Parental\HasChildren;

/**
 * \App\Models\Content
 *
 * @property string $id
 * @property string $title
 * @property Editor $body
 * @property-read Status $status
 * @property bool $published
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<ContentComment> $comments
 * @property-read \Illuminate\Database\Eloquent\Collection<ContentCollection> $collections
 */
class Content extends Model
{
    use HasChildren, HasFactory, HasMetadata, HasUuids, Likeable, Searchable, Sluggable, SoftDeletes, Viewable;

    protected $table = 'content';

    protected $childTypes = [
        'post' => Post::class,
        'collection' => ContentCollection::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'body', 'metadata', 'published', 'user_id', 'type'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'body' => 'array',
        'published' => 'boolean',
    ];

    /**
     * The attributes that should be defaults.
     *
     * @var array<string, mixed>
     */
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function collections()
    {
        return $this->belongsToMany(ContentCollection::class, 'entries', 'content_id', 'collection_id')->using(
            Entry::class,
        );
    }

    /**
     * Get all of the comments for the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany<\App\Models\Comment>
     */
    public function comments()
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
        return match (true) {
            $status->equals(Status::archived()) => $query->onlyTrashed(),
            $status->equals(Status::published()) => $query->where('published', true),
            $status->equals(Status::draft()) => $query->where('published', false),
        };
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
     * Filter to only include top content for the last month. Top is
     * defined as having the most likes, views, and comments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<self>  $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeTopLastMonth($query)
    {
        return $query
            ->where('published', true)
            ->withCount([
                'likes as last_month_likes' => function ($query) {
                    return $query->lastMonth();
                },
                'views as last_month_views' => function ($query) {
                    return $query->lastMonth();
                },
                'comments as last_month_comments' => function ($query) {
                    return $query->lastMonth();
                },
            ])
            ->orderByDesc('last_month_likes')
            ->orderByDesc('last_month_views')
            ->orderByDesc('last_month_comments')
            ->orderByDesc('created_at');
    }

    /**
     * Apply search constraints to the query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<self>  $query
     * @param  array<string, mixed>  $constraints
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeWithSearchConstraints($query, array $constraints)
    {
        return $query
            ->where('published', true)
            ->when($constraints['type'], fn ($query, $types) => $query->where('type', $types))
            ->when(
                $constraints['grades'],
                fn ($query, $grades) => $query->whereJsonContains('metadata->grades', $grades),
            )
            ->when(
                $constraints['standards'],
                fn ($query, $standards) => $query->whereJsonContains('metadata->standards', $standards),
            )
            ->when(
                $constraints['standard_groups'],
                fn ($query, $standard_groups) => $query->where(
                    fn ($query) => collect($standard_groups)
                        ->map(
                            fn ($group) => $query->orWhereJsonContains(
                                'metadata->standards',
                                Standard::getGroup(StandardGroup::from($group)),
                            ),
                        )
                        ->flatten(),
                ),
            )
            ->when(
                $constraints['practices'],
                fn ($query, $practices) => $query->whereJsonContains('metadata->practices', $practices),
            )
            ->when(
                $constraints['languages'],
                fn ($query, $languages) => $query->whereJsonContains('metadata->languages', $languages),
            )
            ->when(
                $constraints['categories'],
                fn ($query, $categories) => $query->whereIn('metadata->category', $categories),
            )
            ->when(
                $constraints['audiences'],
                fn ($query, $audiences) => $query->whereIn('metadata->audience', $audiences),
            )
            ->whereHas('likes', null, '>=', $constraints['likes_count'])
            ->whereHas('views', null, '>=', $constraints['views_count']);
    }

    // Methods

    public static function normalizeSearchConstraints(array $constraints): array
    {
        return [
            'type' => data_get($constraints, 'type', ''),
            'categories' => Arr::wrap(data_get($constraints, 'categories', [])),
            'audiences' => Arr::wrap(data_get($constraints, 'audiences', [])),
            'grades' => Arr::wrap(data_get($constraints, 'grades', [])),
            'standards' => Arr::wrap(data_get($constraints, 'standards', [])),
            'practices' => Arr::wrap(data_get($constraints, 'practices', [])),
            'languages' => Arr::wrap(data_get($constraints, 'languages', [])),
            'standard_groups' => Arr::wrap(data_get($constraints, 'standard_groups', [])),
            'likes_count' => data_get($constraints, 'likes_count', 0),
            'views_count' => data_get($constraints, 'views_count', 0),
        ];
    }

    public function scopeAreSearchable(Builder $query)
    {
        return $query->where('published', true)->whereNull('deleted_at');
    }
}
