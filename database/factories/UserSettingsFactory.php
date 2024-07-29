<?php

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
            'receive_weekly_digest' => $this->faker->boolean(),
            'receive_comment_notifications' => $this->faker->boolean(),
            'receive_new_follower_notifications' => $this->faker->boolean(),
            'receive_follower_notifications' => $this->faker->boolean(),
        ];
    }
}
