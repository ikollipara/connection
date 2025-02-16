<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\ValueObjects\Editor;
use App\ValueObjects\Metadata;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
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
            'title' => fake()->word(),
            'metadata' => Metadata::fromFaker($this->faker),
            'body' => Editor::fromJson(json_encode(['blocks' => []])),
            'user_id' => User::factory(),
            'published' => fake()->boolean(),
            'type' => fake()->randomElement(['post', 'collection']),
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
