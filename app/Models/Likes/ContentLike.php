<?php

namespace App\Models\Likes;

use App\Models\Content;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * \App\Models\Likes\ContentLike
 * @property int $id
 * @property string $user_id
 * @property string $content_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Content $content
 * @property \App\Models\User $user
 */
class ContentLike extends Model
{
    protected $table = "content_likes";

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = ["user_id", "content_id"];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        "created_at" => "datetime",
        "updated_at" => "datetime",
    ];

    // Relationships

    /**
     * Get the content that the like belongs to.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Content>
     */
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    /**
     * Get the user that liked the content.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
