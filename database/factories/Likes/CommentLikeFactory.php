<?php

declare(strict_types=1);

namespace Database\Factories\Likes;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentLikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'comment_id' => Comment::factory(),
        ];
    }
}
