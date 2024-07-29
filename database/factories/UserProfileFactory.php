<?php

namespace Database\Factories;

use App\Enums\Grade;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $is_preservice = $this->faker->boolean();

        return [
            'user_id' => User::factory(),
            'bio' => json_encode(['blocks' => []]),
            'is_preservice' => $is_preservice,
            'school' => $this->faker->sentence(),
            'subject' => $this->faker->sentence(),
            'gender' => '',
            'grades' => $this->faker->randomElements(
                Grade::toValues(),
                $this->faker->numberBetween(1, 3),
            ),
            'years_of_experience' => $is_preservice
                ? 0
                : $this->faker->numberBetween(0, 10),
        ];
    }

    public function preservice()
    {
        return $this->state([
            'is_preservice' => true,
            'years_of_experience' => 0,
        ]);
    }

    public function experienced()
    {
        return $this->state([
            'is_preservice' => false,
            'years_of_experience' => $this->faker->numberBetween(0, 10),
        ]);
    }
}
