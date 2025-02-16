<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Grade;
use App\Models\User;
use App\ValueObjects\Editor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 *  @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $is_preservice = fake()->boolean();

        return [
            'user_id' => User::factory(),
            'bio' => Editor::fromJson(json_encode(['blocks' => []])),
            'is_preservice' => $is_preservice,
            'school' => fake()->sentence(),
            'subject' => fake()->sentence(),
            'gender' => '',
            'grades' => fake()->randomElements(
                Grade::toValues(),
                fake()->numberBetween(1, 3),
            ),
            'years_of_experience' => $is_preservice
                ? 0
                : fake()->numberBetween(0, 10),
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
            'years_of_experience' => fake()->numberBetween(0, 10),
        ]);
    }
}
