<?php

namespace Database\Factories\Likes;

use App\Models\Content;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContentLikeFactory extends Factory
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
            'content_id' => Content::factory(),
        ];
    }
}
