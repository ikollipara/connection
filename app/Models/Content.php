<?php

namespace App\Models;

use App\Contracts\Commentable;
use App\Contracts\IsSearchable;
use App\Enums\Standard;
use App\Enums\StandardGroup;
use App\Enums\Status;
use App\Models\Concerns\HasMetadata;
use App\ValueObjects\Editor;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
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
 * @property-read \Illuminate\Database\Eloquent\Collection<PostCollection> $collections
 */
class Content extends Model implements Commentable, IsSearchable
{
    use HasFactory, HasChildren, HasUuids, HasMetadata, SoftDeletes, Searchable;

    protected $table = 'content';

    protected $childTypes = [
        'post' => Post::class,
        'collection' => PostCollection::class,
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = ['user'];

    /**
     * The relationships that should always be counted.
     *
     * @var array<int, string>
     */
    protected $withCount = ['likes', 'views'];

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

    // Laravel Scout configuration
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'body' => $this->asPlainText('body'),
        ];
    }

    public function shouldBeSearchable()
    {
        return $this->published and ! $this->trashed();
    }

    // Overrides

    public function getRouteKey()
    {
        return Str::slug($this->title).'--'.$this->getAttribute($this->getRouteKeyName());
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $id = last(explode('--', $value));

        return parent::resolveRouteBinding($id, $field);
    }

    public function resolveSoftDeletableRouteBinding($value, $field = null)
    {
        $id = last(explode('--', $value));

        return parent::resolveSoftDeletableRouteBinding($id, $field);
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
        $this->attributes["body"] = $value->toJson();
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

    /**
     * Get the likes for the content.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Likes\ContentLike>
     */
    public function likes()
    {
        return $this->hasMany(Likes\ContentLike::class);
    }

    /**
     * Get the views for the content.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\View>
     */
    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function collections()
    {
        return $this->belongsToMany(PostCollection::class, 'entries', 'content_id', 'collection_id')->using(
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
        switch (true) {
            case $status->equals(Status::archived()):
                return $query->onlyTrashed();
            case $status->equals(Status::published()):
                return $query->where('published', true);
            case $status->equals(Status::draft()):
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
}
