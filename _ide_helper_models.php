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
 * @property-read \App\Models\Event|null $event
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\AttendeeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee query()
 */
	class Attendee extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Likes\CommentLike> $likes
 * @property-read int|null $likes_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\CommentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Comment lastMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment thisMonth()
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
 * @property-read \Illuminate\Database\Eloquent\Collection<PostCollection> $collections
 * @property-read \App\Models\Entry $pivot
 * @property-read int|null $collections_count
 * @property-read int|null $comments_count
 * @property mixed $metadata
 * @property-read mixed $was_recently_published
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Likes\ContentLike> $likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\View> $views
 * @property-read int|null $views_count
 * @method static \Database\Factories\ContentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Content newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Content onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Content query()
 * @method static \Illuminate\Database\Eloquent\Builder|Content status(\App\Enums\Status $status)
 * @method static \Illuminate\Database\Eloquent\Builder|Content topLastMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|Content wherePublished()
 * @method static \Illuminate\Database\Eloquent\Builder|Content withSearchConstraints(array $constraints)
 * @method static \Illuminate\Database\Eloquent\Builder|Content withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Content withoutTrashed()
 */
	class Content extends \Eloquent implements \App\Contracts\Commentable, \App\Contracts\IsSearchable {}
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
 * @property \App\Models\PostCollection $collection
 * @method static \Database\Factories\EntryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Entry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entry query()
 */
	class Entry extends \Eloquent {}
}

namespace App\Models{
/**
 * Event
 * 
 * An event is a scheduled activity that has a title, start date, and end date.
 *
 * @property int $id The unique identifier of the event.
 * @property string $title The title of the event.
 * @property string $location where the event is happening
 * @property array $description The description of the event.
 * @property string $user_id The unique identifier of the user who created the event.
 * @property Carbon $start The date when the event starts.
 * @property Carbon $end The date when the event ends.
 * @property bool $is_all_day Indicates if the event is an all-day event.
 * @property string $display_picture The display picture of the event.
 * @property Carbon $created_at The date and time when the event was created.
 * @property Carbon $updated_at The date and time when the event was last updated.
 * @property Carbon $deleted_at The date and time when the event was deleted.
 * @property-read string $description_text The description of the event as plain text.
 * @property User $user The user who created the event.
 * @property Attendee $attendees people who are attending the event
 * @property-read int|null $attendees_count
 * @property mixed $metadata
 * @method static \Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event withoutTrashed()
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
 * @property-read \App\Models\User|null $followed
 * @property-read \App\Models\User|null $follower
 * @method static \Database\Factories\FollowerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Follower newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Follower newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Follower query()
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
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion answered()
 * @method static \Database\Factories\FrequentlyAskedQuestionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion search(string $search)
 * @method static \Illuminate\Database\Eloquent\Builder|FrequentlyAskedQuestion unanswered()
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
 */
	class ContentLike extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Post
 *
 * @property-read \App\Models\Entry $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostCollection> $collections
 * @property-read int|null $collections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property mixed $body
 * @property mixed $metadata
 * @property-read mixed $status
 * @property-read mixed $was_recently_published
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Likes\ContentLike> $likes
 * @property-read int|null $likes_count
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\View> $views
 * @property-read int|null $views_count
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post status(\App\Enums\Status $status)
 * @method static \Illuminate\Database\Eloquent\Builder|Post topLastMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublished()
 * @method static \Illuminate\Database\Eloquent\Builder|Post withSearchConstraints(array $constraints)
 * @method static \Illuminate\Database\Eloquent\Builder|Post withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Post withoutTrashed()
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<Content> $entries
 * @property-read int $entries_count
 * @property-read \App\Models\Entry $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, PostCollection> $collections
 * @property-read int|null $collections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property mixed $body
 * @property mixed $metadata
 * @property-read mixed $status
 * @property-read mixed $was_recently_published
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Likes\ContentLike> $likes
 * @property-read int|null $likes_count
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\View> $views
 * @property-read int|null $views_count
 * @method static \Database\Factories\PostCollectionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PostCollection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCollection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCollection onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCollection query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCollection status(\App\Enums\Status $status)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCollection topLastMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCollection wherePublished()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCollection withSearchConstraints(array $constraints)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCollection withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCollection withoutTrashed()
 */
	class PostCollection extends \Eloquent {}
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
 */
	class Search extends \Eloquent {}
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
 * @property-read string $bio_text
 * @property string $gender
 * @property int $years_of_experience
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\UserProfileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile query()
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
 */
	class View extends \Eloquent {}
}

