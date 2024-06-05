<?php

namespace App\Models;

use App\Contracts\Commentable;
use App\Enums\Standard;
use App\Enums\Status;
use App\Models\Concerns\HasMetadata;
use App\Models\Concerns\HasRichText;
use App\Traits\HasComments;
use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Parental\HasChildren;

/**
 * \App\Models\Content
 * @property string $id
 * @property string $title
 * @property array<string, string> $body
 * @property-read string $body_text
 * @property-read Status $status
 * @property bool $published
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<Comment> $comments
 */
class Content extends Model implements Commentable
{
    use HasFactory,
        HasChildren,
        HasUuids,
        HasRichText,
        HasMetadata,
        SoftDeletes,
        Searchable,
        HasComments;
    protected $table = "content";

    protected $childTypes = [
        "post" => Post::class,
        "collection" => PostCollection::class,
    ];

    /**
     * The relationships that should always be loaded.
     * @var array<int, string>
     */
    protected $with = ["user"];

    /**
     * The relationships that should always be counted.
     * @var array<int, string>
     */
    protected $withCount = ["likes", "views"];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "title",
        "body",
        "metadata",
        "published",
        "user_id",
        "type",
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        "body" => "array",
        "published" => "boolean",
    ];

    /**
     * The attributes that should be defaults.
     * @var array<string, mixed>
     */
    protected $attributes = [
        "published" => false,
        "metadata" => '{"category": "material", "audience": "Teachers"}',
        "body" => '{"blocks": []}',
        "title" => "",
    ];

    /**
     * Attributes that should be parsed from rich text.
     * @var array<string>
     */
    protected $rich_text_attributes = ["body"];

    // Laravel Scout configuration
    public function toSearchableArray()
    {
        return [
            "title" => $this->title,
            "body" => $this->body_text,
        ];
    }

    public function shouldBeSearchable()
    {
        return $this->published and !$this->trashed();
    }

    // Overrides

    public function getRouteKey()
    {
        return Str::slug($this->title) .
            "--" .
            $this->getAttribute($this->getRouteKeyName());
    }

    public function resolveSoftDeletableRouteBinding($value, $field = null)
    {
        $id = last(explode("--", $value));
        return parent::resolveSoftDeletableRouteBinding($id, $field);
    }

    // Accessors and Mutators

    public function getWasRecentlyPublishedAttribute()
    {
        return $this->published and $this->wasChanged("published");
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

    // Relationships

    /**
     * Get the user that owns the content.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the likes for the content.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Likes\ContentLike>
     */
    public function likes()
    {
        return $this->hasMany(Likes\ContentLike::class);
    }

    /**
     * Get the views for the content.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\View>
     */
    public function views()
    {
        return $this->hasMany(View::class);
    }

    // Scopes

    /**
     * Filter the query by status.
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @param Status $status
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeStatus($query, Status $status)
    {
        if ($status->equals(Status::archived())) {
            return $query->onlyTrashed();
        }
        if ($status->equals(Status::published())) {
            return $query->where("published", true);
        }
        if ($status->equals(Status::draft())) {
            return $query->where("published", false);
        }
        return $query;
    }

    /**
     * Filter the query by published status.
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeWherePublished($query)
    {
        return $query->where("published", true);
    }

    /**
     * Filter the query by the given constraints.
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @param array<string, mixed> $constraints
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeApplySearchConstraints($query, array $constraints)
    {
        return $query
            ->where("published", true)
            ->when(
                count($constraints["grades"]) > 0,
                fn($query) => $query->whereJsonContains(
                    "metadata->grades",
                    $constraints["grades"],
                ),
            )
            ->when(
                count($constraints["standards"]) > 0,
                fn($query) => $query->whereJsonContains(
                    "metadata->standards",
                    $constraints["standards"],
                ),
            )
            ->when(count($constraints["standard_groups"]) > 0, function (
                $query
            ) use ($constraints) {
                $standards = collect($constraints["standard_groups"])
                    ->map(fn($group) => Standard::getGroup($group))
                    ->flatten();
                return $query->where(
                    fn($query) => $standards->map(
                        fn($standard) => $query->orWhereJsonContains(
                            "metadata->standards",
                            $standard,
                        ),
                    ),
                );
            })
            ->when(
                count($constraints["practices"]) > 0,
                fn($query) => $query->whereJsonContains(
                    "metadata->practices",
                    $constraints["practices"],
                ),
            )
            ->when(
                count($constraints["languages"]) > 0,
                fn($query) => $query->whereJsonContains(
                    "metadata->languages",
                    $constraints["languages"],
                ),
            )
            ->when(
                count($constraints["categories"]) > 0,
                fn($query) => $query->whereIn(
                    "metadata->category",
                    $constraints["categories"],
                ),
            )
            ->when(
                count($constraints["audiences"]) > 0,
                fn($query) => $query->whereIn(
                    "metadata->audience",
                    $constraints["audiences"],
                ),
            )
            ->whereHas("likes", null, ">=", $constraints["likes_count"])
            ->whereHas("views", null, ">=", $constraints["views_count"]);
    }

    // Methods
}
