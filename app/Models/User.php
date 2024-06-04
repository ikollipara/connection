<?php

namespace App\Models;

use App\Casts\Hashed;
use App\Events\UserFollowed;
use App\Mail\Survey;
use App\Notifications\QualtricsSurvey;
use App\Services\SurveyService;
use App\Traits\HasUuids;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

/**
 * App\Models\User
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $avatar
 * @property string $school
 * @property string $subject
 * @property string $gender
 * @property array<string, string> $bio
 * @property array<string> $grades
 * @property string $email
 * @property bool $no_comment_notifications
 * @property bool $consented
 * @property bool $is_preservice
 * @property int $years_of_experience
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $sent_week_one_survey
 * @property \Illuminate\Support\Carbon|null $yearly_survey_sent_at
 * @property bool $receive_weekly_digest
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\Comment> $comments
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\PostCollection> $postCollections
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\Post> $posts
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\User> $followers
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\User> $following
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\Search> $searches
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "first_name",
        "last_name",
        "avatar",
        "school",
        "subject",
        "gender",
        "bio",
        "grades",
        "email",
        "password",
        "no_comment_notifications",
        "years_of_experience",
        "is_preservice",
        "receive_weekly_digest",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "email_verified_at" => "datetime",
        "bio" => "array",
        "grades" => "array",
        "no_comment_notifications" => "boolean",
        "consented" => "boolean",
        "is_preservice" => "boolean",
        "sent_week_one_survey" => "boolean",
        "yearly_survey_sent_at" => "datetime",
        "receive_weekly_digest" => "boolean",
    ];

    /** @var array<string, mixed> */
    protected $attributes = [
        "password" => "",
        "gender" => "",
        "is_preservice" => false,
        "school" => "",
        "bio" => '{"blocks": []}',
        "years_of_experience" => 0,
    ];

    public static function booted()
    {
        // Before creating the user, we normalize the email.
        static::creating(function (User $user) {
            $user->email = Str::of($user->email)
                ->trim()
                ->lower();
        });
        static::created(function (User $user) {
            event(new Registered($user));
        });
        static::saved(function (User $user) {
            if ($user->consented and $user->wasChanged("consented")) {
                $url =
                    env("APP_QUALTRICS_CONSENT_LINK") . "?user_id={$user->id}";
                Mail::to($user)->queue(new Survey($url));
            }
        });
    }

    /**
     * Get the user's followers
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<self>
     * @see \App\Models\User::followers()
     */
    public function followers()
    {
        return $this->belongsToMany(
            self::class,
            "followers",
            "followed_id",
            "follower_id",
        )->using(Follower::class);
    }

    /**
     * Get the users who the users is following
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<self>
     */
    public function following()
    {
        return $this->belongsToMany(
            self::class,
            "followers",
            "follower_id",
            "followed_id",
        )->using(Follower::class);
    }

    /**
     * Get the user's posts
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Post>
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the user's post collections
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\PostCollection>
     */
    public function postCollections()
    {
        return $this->hasMany(PostCollection::class);
    }

    /**
     * Get the user's comments
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Comment>
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the user's searches
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Search>
     */
    public function searches()
    {
        return $this->hasMany(Search::class);
    }

    /**
     * Get the user's full name.
     * @return string The User's full name
     */
    public function full_name()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function avatar(): string
    {
        /**
         * If the user doesn't have an avatar,
         * we generate one using the user's full name
         * using the ui-avatars.com API.
         */
        if (!$this->avatar) {
            $full_name = Str::of($this->full_name())
                ->trim()
                ->replace(" ", "+");
            return "https://ui-avatars.com/api/?name={$full_name}&color=7F9CF5&background=EBF4FF";
        }
        return Storage::url($this->avatar);
    }

    /**
     * Scope a query to only include preservice users.
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopePreservice($query)
    {
        return $query->where("is_preservice", true);
    }
}
