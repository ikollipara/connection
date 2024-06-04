<?php

/**
 * |=============================================================================|
 * | Follower.php                                                                |
 * |-----------------------------------------------------------------------------|
 * | Defines the Follower model.                                                 |
 * |=============================================================================| */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

/**
 * |=============================================================================|
 * | Follower                                                                    |
 * |=============================================================================|
 * @property int $id
 * @property string $followed_id
 * @property string $follower_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Follower extends Model
{
    use HasFactory, AsPivot;

    protected $table = "followers";
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ["followed_id", "follower_id"];

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        "user_id" => "string",
        "follower_id" => "string",
    ];

    /**
     * Get the user that the followed belongs to.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function followed()
    {
        return $this->belongsTo(User::class, "followed_id");
    }

    /**
     * Get the user that the follower belongs to.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function follower()
    {
        return $this->belongsTo(User::class, "follower_id");
    }
}
