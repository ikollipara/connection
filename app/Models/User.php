<?php

declare(strict_types=1);

namespace App\Models;

// use App\Mail\Survey;

use App\Mail\Login;
use App\ValueObjects\Avatar;
use Illuminate\Contracts\Auth\Authenticatable as AuthContract;
use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasVersion4Uuids as HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Mail;

class User extends Authenticatable implements AuthContract, MustVerifyEmail
{
    use HasApiTokens, HasUuids, Notifiable;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'avatar', 'email', 'consented'];

    protected $hidden = ['remember_token'];

    protected static function booted()
    {
        // Before creating the user, we normalize the email.
        static::creating(function (User $user) {
            $user->email = str($user->email)->trim()->lower()->toString();
        });
    }

    // Overrides

    public function getRouteKey()
    {
        return '@'.Str::slug($this->full_name, '-').'--'.$this->getAttribute($this->getRouteKeyName());
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
     * @return Attribute<string, null>
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(get: function (): string {
            return "{$this->first_name} {$this->last_name}";
        });
    }

    /**
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
     * Get the user's comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Comment, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Scopes

    public function sendLoginLink(): void
    {
        Mail::to($this)->queue(new Login($this));
    }

    /**
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
