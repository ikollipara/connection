<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\ValueObjects\Metadata;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostCollectionFactory extends Factory
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
            'type' => 'collection',
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
}
