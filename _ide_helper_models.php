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
 * @property-read Comment|null $parent
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\CommentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment orderByLikes($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment root()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUserId($value)
 */
	class Comment extends \Eloquent {}
}

namespace App\Models{
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
 * @property string|null $user_id
 * @property string $metadata
 * @property int $views
 * @property int $likes_count
 * @property string|null $type
 * @property-read \App\Models\Entry $pivot
 * @property-read int|null $collections_count
 * @property-read int|null $comments_count
 * @property-read mixed $was_recently_published
 * @method static \Illuminate\Database\Eloquent\Builder|Content areSearchable()
 * @method static \Database\Factories\ContentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Content filterBy(array $params)
 * @method static \Illuminate\Database\Eloquent\Builder|Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Content newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Content onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Content orderByLikes($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder|Content orderByViews($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder|Content query()
 * @method static \Illuminate\Database\Eloquent\Builder|Content search(?string $queryText)
 * @method static \Illuminate\Database\Eloquent\Builder|Content shouldBeSearchable()
 * @method static \Illuminate\Database\Eloquent\Builder|Content status(\App\Enums\Status $status)
 * @method static \Illuminate\Database\Eloquent\Builder|Content topLastMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereLikesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content withSearchConstraints(array $constraints)
 * @method static \Illuminate\Database\Eloquent\Builder|Content withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Content withoutTrashed()
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
 * @property array $body
 * @property string|null $user_id
 * @property string $metadata
 * @property bool $published
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $likes_count
 * @property string|null $type
 * @property-read \App\Models\Entry $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ContentCollection> $collections
 * @property-read int|null $collections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read mixed $status
 * @property-read mixed $was_recently_published
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection areSearchable()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection filterBy(array $params)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection orderByLikes($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection orderByViews($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection search(?string $queryText)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection shouldBeSearchable()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection status(\App\Enums\Status $status)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection topLastMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection whereLikesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection withHasEntry($content = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection withSearchConstraints(array $constraints)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCollection withoutTrashed()
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
 * @method static \Illuminate\Database\Eloquent\Builder|Day newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Day newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Day query()
 * @method static \Illuminate\Database\Eloquent\Builder|Day whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Day whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Day whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Day whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Day whereUpdatedAt($value)
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
 * @method static \Database\Factories\EntryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Entry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entry query()
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereCollectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereUpdatedAt($value)
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
 * @property mixed $start
 * @property mixed|null $end
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Day> $days
 * @property string $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $attendees
 * @property-read int|null $attendees_count
 * @property-read int|null $days_count
 * @property \App\ValueObjects\Editor $description_attribute
 * @property-read mixed $is_cloned_attribute
 * @property-read mixed $is_source_attribute
 * @property-read Event|null $source
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Event isAttending(\App\Models\User $user)
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event orderByLikes($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder|Event orderByViews($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereClonedFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUserId($value)
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
 * @method static \Database\Factories\FollowerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Follower newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Follower newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Follower query()
 * @method static \Illuminate\Database\Eloquent\Builder|Follower whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follower whereFollowedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follower whereFollowerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follower whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follower whereUpdatedAt($value)
 */
	class Follower extends \Eloquent {}
}

namespace App\Models{
/**
 * |=============================================================================|
 * | FrequentlyAskedQuestion                                                     |
 * |-----------------------------------------------------------------------------|
 * | This model represents a frequently asked question.                          |
 * |=============================================================================|
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $user_id
 * @property \Illuminate\Support\Carbon|null $answered_at
 * @property string|null $answer
 * @property-read bool $is_answered
 * @property-read float $rating
 * @property-read string $content_excerpt
 * @property-read string $answer_excerpt
 * @property \Illuminate\Database\Eloquent\Collection $history
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \App\Models\User|null $user
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion answered()
 * @method static \Database\Factories\FrequentlyAskedQuestionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion search(string $search)
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion unanswered()
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion whereAnsweredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion whereHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion withoutTrashed()
 */
	class FrequentlyAskedQuestion extends \Eloquent {}
}

namespace App\Models\Likes{
/**
 * App\Models\CommentLike
 *
 * @property int $id
 * @property string $user_id
 * @property string $comment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Comment $comment
 * @property \App\Models\User $user
 * @method static \Database\Factories\Likes\CommentLikeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|CommentLike newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentLike newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentLike query()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentLike whereCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentLike whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentLike whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentLike whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentLike whereUserId($value)
 */
	class CommentLike extends \Eloquent {}
}

namespace App\Models\Likes{
/**
 * \App\Models\Likes\ContentLike
 *
 * @property int $id
 * @property string $user_id
 * @property string $content_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Content $content
 * @property \App\Models\User $user
 * @method static \Database\Factories\Likes\ContentLikeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ContentLike lastMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentLike newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentLike newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentLike query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentLike thisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentLike whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentLike whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentLike whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentLike whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentLike whereUserId($value)
 */
	class ContentLike extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Post
 *
 * @property string $id
 * @property string $title
 * @property array $body
 * @property string|null $user_id
 * @property string $metadata
 * @property bool $published
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $likes_count
 * @property string|null $type
 * @property-read \App\Models\Entry $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContentCollection> $collections
 * @property-read int|null $collections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read mixed $status
 * @property-read mixed $was_recently_published
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Post areSearchable()
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Post filterBy(array $params)
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Post orderByLikes($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder|Post orderByViews($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post search(?string $queryText)
 * @method static \Illuminate\Database\Eloquent\Builder|Post shouldBeSearchable()
 * @method static \Illuminate\Database\Eloquent\Builder|Post status(\App\Enums\Status $status)
 * @method static \Illuminate\Database\Eloquent\Builder|Post topLastMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereLikesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post withSearchConstraints(array $constraints)
 * @method static \Illuminate\Database\Eloquent\Builder|Post withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Post withoutTrashed()
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
 * @method static \Illuminate\Database\Eloquent\Builder|Search newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Search newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Search query()
 * @method static \Illuminate\Database\Eloquent\Builder|Search whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Search whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Search whereSearchParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Search whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Search whereUserId($value)
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
 * @property Avatar $avatar
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
 * @property-read \App\Models\Follower $pivot
 * @property-read int|null $followers_count
 * @property-read int|null $following_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read int|null $posts_count
 * @property-read int|null $searches_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereConsented($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSentWeekOneSurvey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereYearlySurveySentAt($value)
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
 * @method static \Database\Factories\UserProfileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile orderByViews($direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereGrades($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereIsPreservice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereYearsOfExperience($value)
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
 * @method static \Database\Factories\UserSettingsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings whereReceiveCommentNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings whereReceiveFollowerNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings whereReceiveNewFollowerNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings whereReceiveWeeklyDigest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings whereUserId($value)
 */
	class UserSettings extends \Eloquent {}
}

namespace App\Models{
/**
 * \App\Models\View
 *
 * @property int $id
 * @property string $user_id
 * @property string $content_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Content $content
 * @property \App\Models\User $user
 * @method static \Database\Factories\ViewFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|View lastMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|View newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|View newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|View query()
 * @method static \Illuminate\Database\Eloquent\Builder|View thisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|View whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|View whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|View whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|View whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|View whereUserId($value)
 */
	class View extends \Eloquent {}
}

