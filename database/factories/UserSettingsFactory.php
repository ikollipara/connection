<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserSettingsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'receive_weekly_digest' => fake()->boolean(),
            'receive_comment_notifications' => fake()->boolean(),
            'receive_new_follower_notifications' => fake()->boolean(),
            'receive_follower_notifications' => fake()->boolean(),
        ];
    }
}
