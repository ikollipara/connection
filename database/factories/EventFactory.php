<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\ValueObjects\Editor;
use App\ValueObjects\Metadata;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'title' => fake()->word(),
            'description' => new Editor(['blocks' => []]),
            'location' => fake()->address(),
            'user_id' => User::factory(),
            'start' => now()->toImmutable(),
            'end' => now()->toImmutable()->addDays(5),
            'metadata' => Metadata::fromFaker(fake()),

        ];
    }

    public function hasEndDate()
    {
        return $this->state(function (array $attributes) {
            return [
                'end_date' => now()->toImmutable()->addDays(5),
            ];
        });
    }
}
