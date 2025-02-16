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
use Illuminate\Contracts\Auth\Authenticatable as AuthContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Mail;
use Illuminate\Support\Carbon;

class User extends Authenticatable implements MustVerifyEmail, AuthContract
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasApiTokens, HasUuids, Notifiable;

    protected $fillable = ['first_name', 'last_name', 'avatar', 'email', 'consented'];

    protected $hidden = ['remember_token'];

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

    private function notifyIfConsented(): void
    {
        if ($this->consented and ($this->wasChanged('consented') or $this->wasRecentlyCreated)) {
            (new SurveyService($this))->sendSurvey([SurveyService::SCALES], SurveyService::ONCE);
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
            return auth('web')->user();
        }
        $id = last(explode('--', $value));

        return parent::resolveRouteBinding($id, $field);
    }

    /**
     *
     * @return Attribute<string, null>
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(get: function (): string {
            return "{$this->first_name} {$this->last_name}";
        });
    }

    /**
     *
     * @return Attribute<Avatar, Avatar|string>
     */
    protected function avatar(): Attribute
    {
        return Attribute::make(get: function (): Avatar {
            $avatar = new Avatar(Arr::get($this->attributes, 'avatar', ''));
            $full_name = trim(str_replace(' ', '+', $this->full_name));
            $avatar->setDefault("https://ui-avatars.com/api/?name={$full_name}&color=7F9CF5&background=EBF4FF");
            return $avatar;
        }, set: function (string|Avatar $value): array {
            $value = is_string($value) ? new Avatar($value) : $value;
            return ['avatar' => $value->path()];
        })->withoutObjectCaching();
    }

    // Relationships

    /**
     * Get the user's followers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<self, $this>
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<self, $this>
     */
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'followers', 'follower_id', 'followed_id')->using(Follower::class);
    }

    /**
     * What events the user is attending.
     *
     * @return BelongsToMany<Event, $this>
     */
    public function attending(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'attendees');
    }

    /**
     * Get the user's settings
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<UserSettings, $this>
     */
    public function settings(): HasOne
    {
        return $this->hasOne(UserSettings::class);
    }

    /**
     * Get the user's profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<UserProfile, $this>
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the user's content
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Content, $this>
     */
    public function content(): HasMany
    {
        return $this->hasMany(Content::class);
    }

    /**
     * Get the user's posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Post, $this>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the user's post collections
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<ContentCollection, $this>
     */
    public function collections(): HasMany
    {
        return $this->hasMany(ContentCollection::class);
    }

    /**
     * Get the user's Events
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Event, $this>
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get the user's comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Comment, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the user's searches
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Search, $this>
     */
    public function searches(): HasMany
    {
        return $this->hasMany(Search::class);
    }

    // Scopes

    public function sendLoginLink(): void
    {
        Mail::to($this)->queue(new Login($this));
    }

    public function isFollowing(User $user): bool
    {
        return $this->following()->where('followed_id', $user->id)->exists();
    }
    /**
     *
     * @return array{email_verified_at: 'datetime', consented: 'boolean', sent_week_one_survey: 'boolean', yearly_survey_sent_at: 'datetime'}
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'consented' => 'boolean',
            'sent_week_one_survey' => 'boolean',
            'yearly_survey_sent_at' => 'datetime',
        ];
    }
}
