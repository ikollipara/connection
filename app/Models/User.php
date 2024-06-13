<?php

namespace App\Models;

// use App\Mail\Survey;

use App\Enums\Grade;
use App\Traits\HasUuids;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

/**
 * App\Models\User
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property-read string $full_name
 * @property string $avatar
 * @property string $email
 * @property bool $consented
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $sent_week_one_survey
 * @property \Illuminate\Support\Carbon|null $yearly_survey_sent_at
 * @property-read Collection<\App\Models\Comment> $comments
 * @property-read Collection<\App\Models\PostCollection> $collections
 * @property-read Collection<\App\Models\Post> $posts
 * @property-read Collection<\App\Models\User> $followers
 * @property-read Collection<\App\Models\User> $following
 * @property-read Collection<\App\Models\Search> $searches
 * @property UserSettings $settings
 * @property UserProfile $profile
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["first_name", "last_name", "avatar", "email"];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ["remember_token"];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "email_verified_at" => "datetime",
        "consented" => "boolean",
        "sent_week_one_survey" => "boolean",
        "yearly_survey_sent_at" => "datetime",
    ];

    public static function booted()
    {
        // Before creating the user, we normalize the email.
        static::creating(function (User $user) {
            $user->email = trim(strtolower($user->email));
        });
        static::created(function (User $user) {
            event(new Registered($user));
        });
        // static::saved(function (User $user) {
        //     if ($user->consented and $user->wasChanged("consented")) {
        //         $url =
        //             env("APP_QUALTRICS_CONSENT_LINK") . "?user_id={$user->id}";
        //         Mail::to($user)->queue(new Survey($url));
        //     }
        // });
    }

    // Overrides

    public function getRouteKey()
    {
        return "@" .
            Str::slug($this->full_name, "-") .
            "--" .
            $this->getAttribute($this->getRouteKeyName());
    }

    public function resolveRouteBinding($value, $field = null)
    {
        if ($value == "me") {
            return auth()->user();
        }
        $id = last(explode("--", $value));
        return parent::resolveRouteBinding($id, $field);
    }

    // Accessors and Mutators

    /**
     * Get the user's full name.
     * @return string The user's full name
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's avatar
     * @return string The user's avatar
     */
    public function getAvatarAttribute(): string
    {
        if (!$this->attributes["avatar"]) {
            $full_name = trim(str_replace(" ", "+", $this->full_name));
            return "https://ui-avatars.com/api/?name={$full_name}&color=7F9CF5&background=EBF4FF";
        }
        return Storage::url($this->attributes["avatar"]);
    }

    /**
     * Set the user's avatar
     * @param UploadedFile $value The new avatar file
     */
    public function setAvatarAttribute(UploadedFile $value): void
    {
        if ($this->attributes["avatar"]) {
            Storage::delete($this->attributes["avatar"]);
        }
        $this->attributes["avatar"] = $value->store("avatars", "public");
    }

    // Relationships

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
     * Get the user's settings
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\UserSettings>
     */
    public function settings()
    {
        return $this->hasOne(UserSettings::class);
    }

    /**
     * Get the user's profile
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Profile>
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
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
    public function collections()
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

    // Scopes

    // Methods

    /**
     * Create a User with their profile and settings
     * @param array<string, mixed> $data The user's data
     */
    public static function createWithProfileAndSettings(array $data): User
    {
        $profile = [
            "school" => isset($data["school"]) ? $data["school"] : "",
            "is_preservice" => isset($data["is_preservice"]) ? true : false,
            "years_of_experience" => isset($data["years_of_experience"])
                ? $data["years_of_experience"]
                : 0,
            "subject" => $data["subject"],
            "bio" => json_decode($data["bio"], true),
            "grades" => array_map(
                fn($grade) => Grade::from($grade),
                is_array($data["grades"]) ? $data["grades"] : [$data["grades"]],
            ),
            "gender" => "",
        ];

        $user = User::create([
            "first_name" => $data["first_name"],
            "last_name" => $data["last_name"],
            "email" => $data["email"],
        ]);
        $user->profile()->create($profile);
        $user->settings()->create([
            "receive_weekly_digest" => true,
            "receive_comment_notifications" => true,
            "receive_new_follower_notifications" => true,
            "receive_follower_notifications" => true,
        ]);

        return $user;
    }

    public function updateWithProfile(array $data)
    {
        $profile = [
            "school" => isset($data["school"]) ? $data["school"] : "",
            "is_preservice" => isset($data["is_preservice"]) ? true : false,
            "years_of_experience" => isset($data["years_of_experience"])
                ? $data["years_of_experience"]
                : 0,
            "subject" => $data["subject"],
            "bio" => json_decode($data["bio"], true),
            "grades" => array_map(
                fn($grade) => Grade::from($grade),
                is_array($data["grades"]) ? $data["grades"] : [$data["grades"]],
            ),
            "gender" => "",
        ];
        $this->update([
            "first_name" => $data["first_name"],
            "last_name" => $data["last_name"],
            "email" => $data["email"],
        ]);
        if (isset($data["avatar"])) {
            $this->avatar = $data["avatar"];
        }
        $profile_save = $this->profile()->update($profile);
        $user_save = $this->save();
        return $profile_save and $user_save;
    }
}
