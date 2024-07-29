<?php

namespace Database\Factories;

use App\Models\User;
use App\ValueObjects\Metadata;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'metadata' => Metadata::fromFaker($this->faker),
            'body' => json_encode(['blocks' => []]),
            'user_id' => User::factory(),
            'published' => $this->faker->boolean(),
            'type' => $this->faker->randomElement(['post', 'collection']),
        ];
    }

    public function draft()
    {
        return $this->state([
            'published' => false,
        ]);
    }

    public function published()
    {
        return $this->state([
            'published' => true,
        ]);
    }

    public function post()
    {
        return $this->state([
            'type' => 'post',
        ]);
    }

    public function collection()
    {
        return $this->state([
            'type' => 'collection',
        ]);
    }
}
