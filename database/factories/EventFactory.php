<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
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
        $start_date = $this->faker->dateTimeBetween('next Monday', 'next Monday +31 days');
        $end_date = $this->faker->dateTimeBetween($start_date, $start_date->format('Y-m-d H:i:s').' +3 days');

        return [
            //
            'title' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->address(),
            'user_id' => User::factory(),
            'start_date' => $start_date,
            'end_date' => $this->faker->boolean() ? $end_date : null,
            'start_time' => null,
            'end_time' => null,
            'metadata' => Metadata::fromFaker($this->faker),
            'is_all_day' => true,

        ];
    }

    public function hasEndDate()
    {
        return $this->state(function (array $attributes) {
            return [
                'end_date' => $this->faker->dateTimeBetween($attributes['start_date'], '+5 days'),
            ];
        });
    }
}
