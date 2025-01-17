<?php

declare(strict_types=1);

namespace App\Models;

// use App\Mail\Survey;

use App\Enums\Grade;
use App\Mail\Login;
use App\Services\SurveyService;
use App\ValueObjects\Avatar;
use App\ValueObjects\Editor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Mail;

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
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasUuids, Notifiable;

    protected $fillable = ['first_name', 'last_name', 'avatar', 'email', 'consented'];

    protected $hidden = ['remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'consented' => 'boolean',
        'sent_week_one_survey' => 'boolean',
        'yearly_survey_sent_at' => 'datetime',
    ];

    protected static function booted()
    {
        // Before creating the user, we normalize the email.
        static::creating(function (User $user) {
            $user->email = trim(strtolower($user->email));
        });
        static::created(function (User $user) {
            // event(new Registered($user));
            $user->notifyIfConsented();
        });
        static::saved(function (User $user) {
            $user->notifyIfConsented();
        });
    }

    private function notifyIfConsented()
    {
        if ($this->consented and ($this->wasChanged('consented') or $this->wasRecentlyCreated)) {
            (new SurveyService($this))->sendSurvey(Arr::wrap(SurveyService::SCALES), SurveyService::ONCE);
        }
    }

    // Overrides

    public function getRouteKey()
    {
        return '@' . Str::slug($this->full_name, '-') . '--' . $this->getAttribute($this->getRouteKeyName());
    }

    public function resolveRouteBinding($value, $field = null)
    {
        if ($value === 'me') {
            return auth()->user();
        }
        $id = last(explode('--', $value));

        return parent::resolveRouteBinding($id, $field);
    }

    // Accessors and Mutators

    /**
     * Get the user's full name.
     *
     * @return string The user's full name
     */
    protected function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's avatar
     *
     * @return Avatar The user's avatar
     */
    public function getAvatarAttribute(): Avatar
    {
        $avatar = new Avatar(Arr::get($this->attributes, 'avatar', ''));
        $full_name = trim(str_replace(' ', '+', $this->full_name));
        $avatar->setDefault("https://ui-avatars.com/api/?name={$full_name}&color=7F9CF5&background=EBF4FF");

        return $avatar;
    }

    /**
     * Set the user's avatar
     *
     * @param  Avatar|string  $value  The new avatar object
     */
    public function setAvatarAttribute($value): void
    {
        $value = is_string($value) ? new Avatar($value) : $value;
        $this->attributes['avatar'] = $value->path();
    }

    // Relationships

    /**
     * Get the user's followers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<self, covariant self>
     *
     * @see \App\Models\User::followers()
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'follower_id')->using(Follower::class);
    }

    /**
     * Get the users who the users is following
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<self, covariant self>
     */
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'followers', 'follower_id', 'followed_id')->using(Follower::class);
    }

    /**
     * What events the user is attending.
     *
     * @return BelongsToMany<Event, covariant self>
     */
    public function attending(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'attendees');
    }

    /**
     * Get the user's settings
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<UserSettings, covariant self>
     */
    public function settings(): HasOne
    {
        return $this->hasOne(UserSettings::class);
    }

    /**
     * Get the user's profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<UserProfile, covariant self>
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the user's content
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Content, covariant self>
     */
    public function content(): HasMany
    {
        return $this->hasMany(Content::class);
    }

    /**
     * Get the user's posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Post, covariant self>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the user's post collections
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<ContentCollection, covariant self>
     */
    public function collections(): HasMany
    {
        return $this->hasMany(ContentCollection::class);
    }

    /**
     * Get the user's Events
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Event, covariant self>
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get the user's comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Comment, covariant self>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the user's searches
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Search, covariant self>
     */
    public function searches(): HasMany
    {
        return $this->hasMany(Search::class);
    }

    // Scopes

    // Methods

    /**
     * Create a User with their profile and settings
     *
     * @param  array<string, mixed>  $data  The user's data
     */
    public static function createWithProfileAndSettings(array $data): User
    {
        $profile = [
            'school' => $data['school'],
            'is_preservice' => isset($data['is_preservice']),
            'years_of_experience' => data_get($data, 'years_of_experience', 0),
            'subject' => $data['subject'],
            'bio' => Editor::fromJson($data['bio']),
            'grades' => collect($data['grades'])
                ->map(fn($grade) => Grade::from($grade))
                ->toArray(),
            'gender' => '',
        ];

        return DB::transaction(function () use ($data, $profile) {
            $user = User::create([
                'id' => Str::uuid()->toString(),
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'avatar' => Avatar::is($data['avatar']) ? $data['avatar'] : Avatar::fromUploadedFile($data['avatar']),
            ]);
            $user->profile()->create($profile);
            $user->settings()->create([
                'receive_weekly_digest' => true,
                'receive_comment_notifications' => true,
                'receive_new_follower_notifications' => true,
                'receive_follower_notifications' => true,
            ]);

            return $user;
        });
    }

    public function sendLoginLink()
    {
        Mail::to($this)->queue(new Login($this));
    }

    public function isFollowing(User $user): bool
    {
        return $this->following()->where('followed_id', $user->id)->exists();
    }
}
