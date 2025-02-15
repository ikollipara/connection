<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $body
 * @property string|null $user_id
 * @property string|null $commentable_type
 * @property string|null $commentable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $parent_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Comment> $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $commentable
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read Comment|null $parent
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\CommentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment hasLikesCount($count)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment orderByLikes($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment root()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereUserId($value)
 */
	class Comment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $title
 * @property array<array-key, mixed> $body
 * @property string|null $user_id
 * @property \App\ValueObjects\Metadata $metadata
 * @property bool $published
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $likes_count
 * @property string|null $type
 * @property-read \App\Models\Entry|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContentCollection> $collections
 * @property-read int|null $collections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read mixed $status
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read mixed $was_recently_published
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\ContentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content filterBy(array $params)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content hasLikesCount($count)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content hasViewsCount($count)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content orderByLikes($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content orderByViews($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content search(?string $q)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content shouldBeSearchable()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content status(\App\Enums\Status $status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereLikesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content withoutTrashed()
 */
	class Content extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<Content> $entries
 * @property-read int $entries_count
 * @property string $id
 * @property string $title
 * @property array<array-key, mixed> $body
 * @property string|null $user_id
 * @property \App\ValueObjects\Metadata $metadata
 * @property bool $published
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $likes_count
 * @property string|null $type
 * @property-read \App\Models\Entry|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ContentCollection> $collections
 * @property-read int|null $collections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read mixed $status
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read mixed $was_recently_published
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\ContentCollectionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection filterBy(array $params)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection hasLikesCount($count)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection hasViewsCount($count)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection orderByLikes($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection orderByViews($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection search(?string $q)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection shouldBeSearchable()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection status(\App\Enums\Status $status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection whereLikesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection withHasEntry($content = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContentCollection withoutTrashed()
 */
	class ContentCollection extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $event_id
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Event $event
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Database\Factories\DayFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Day newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Day newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Day query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Day whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Day whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Day whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Day whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Day whereUpdatedAt($value)
 */
	class Day extends \Eloquent {}
}

namespace App\Models{
/**
 * \App\Models\Entry
 *
 * @property int $id
 * @property string $content_id
 * @property string $collection_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Content $content
 * @property \App\Models\ContentCollection $collection
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Database\Factories\EntryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entry query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entry whereCollectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entry whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entry whereUpdatedAt($value)
 */
	class Entry extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property Editor $description
 * @property int $id
 * @property string $title
 * @property string $location
 * @property string $user_id
 * @property int|null $cloned_from
 * @property \Illuminate\Support\Carbon $start
 * @property \Illuminate\Support\Carbon|null $end
 * @property \App\ValueObjects\Metadata $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $attendees
 * @property-read int|null $attendees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Day> $days
 * @property-read int|null $days_count
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read mixed $is_cloned
 * @property-read mixed $is_source
 * @property-read Event|null $source
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event filterBy(array $params)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event hasLikesCount($count)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event hasViewsCount($count)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event isAttending(\App\Models\User $user)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event orderByLikes($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event orderByViews($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event search(?string $q)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event shouldBeSearchable()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereClonedFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereUserId($value)
 */
	class Event extends \Eloquent {}
}

namespace App\Models{
/**
 * |=============================================================================|
 * | Follower                                                                    |
 * |=============================================================================|
 *
 * @property int $id
 * @property string $followed_id
 * @property string $follower_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User $followed
 * @property-read \App\Models\User $follower
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Database\Factories\FollowerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Follower newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Follower newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Follower query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Follower whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Follower whereFollowedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Follower whereFollowerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Follower whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Follower whereUpdatedAt($value)
 */
	class Follower extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Post
 *
 * @property string $id
 * @property string $title
 * @property array<array-key, mixed> $body
 * @property string|null $user_id
 * @property \App\ValueObjects\Metadata $metadata
 * @property bool $published
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $likes_count
 * @property string|null $type
 * @property-read \App\Models\Entry|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContentCollection> $collections
 * @property-read int|null $collections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read mixed $status
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read mixed $was_recently_published
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post filterBy(array $params)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post hasLikesCount($count)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post hasViewsCount($count)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post orderByLikes($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post orderByViews($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post search(?string $q)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post shouldBeSearchable()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post status(\App\Enums\Status $status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereLikesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post withoutTrashed()
 */
	class Post extends \Eloquent implements \App\Contracts\Commentable {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $user_id
 * @property array $search_params
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Search newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Search newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Search query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Search whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Search whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Search whereSearchParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Search whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Search whereUserId($value)
 */
	class Search extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property-read string $full_name
 * @property \App\ValueObjects\Avatar $avatar
 * @property string $email
 * @property bool $consented
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $sent_week_one_survey
 * @property \Illuminate\Support\Carbon|null $yearly_survey_sent_at
 * @property-read Collection<\App\Models\Comment> $comments
 * @property-read Collection<\App\Models\ContentCollection> $collections
 * @property-read Collection<\App\Models\Post> $posts
 *  @property-read Collection<\App\Models\Event> $events
 * @property-read Collection<\App\Models\User> $followers
 * @property-read Collection<\App\Models\User> $following
 * @property-read Collection<\App\Models\Search> $searches
 * @property UserSettings $settings
 * @property UserProfile $profile
 * @property string|null $remember_token
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $attending
 * @property-read int|null $attending_count
 * @property-read int|null $collections_count
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Content> $content
 * @property-read int|null $content_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 * @property-read \App\Models\Follower|null $pivot
 * @property-read int|null $followers_count
 * @property-read int|null $following_count
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read int|null $posts_count
 * @property-read int|null $searches_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereConsented($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSentWeekOneSurvey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereYearlySurveySentAt($value)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App\Models{
/**
 * \App\Models\UserProfile
 *
 * @property int $id
 * @property string $user_id
 * @property Editor $bio
 * @property bool $is_preservice
 * @property string $school
 * @property string $subject
 * @property-read string $short_title
 * @property \Illuminate\Support\Collection<\App\Enums\Grade> $grades
 * @property string $gender
 * @property int $years_of_experience
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Database\Factories\UserProfileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile hasViewsCount($count)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile orderByViews($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereGrades($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereIsPreservice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereYearsOfExperience($value)
 */
	class UserProfile extends \Eloquent {}
}

namespace App\Models{
/**
 * \App\Models\UserSettings
 *
 * @property int $id
 * @property string $user_id
 * @property bool $receive_weekly_digest
 * @property bool $receive_comment_notifications
 * @property bool $receive_new_follower_notifications
 * @property bool $receive_follower_notifications
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \App\Models\User $user
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Database\Factories\UserSettingsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSettings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSettings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSettings query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSettings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSettings whereReceiveCommentNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSettings whereReceiveFollowerNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSettings whereReceiveNewFollowerNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSettings whereReceiveWeeklyDigest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSettings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSettings whereUserId($value)
 */
	class UserSettings extends \Eloquent {}
}

