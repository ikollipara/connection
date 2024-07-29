<?php

/*|=============================================================================|
  | Metadata.php
  | Ian Kollipara <ikollipara2@huskers.unl.edu>
  |-----------------------------------------------------------------------------|
  | This file defines a rich object for handling Metadata around the application.
  |=============================================================================| */

namespace App\ValueObjects;

use App\Enums\Audience;
use App\Enums\Category;
use App\Enums\Grade;
use App\Enums\Language;
use App\Enums\Practice;
use App\Enums\Standard;
use Illuminate\Support\Collection;

/**
 * |=============================================================================|
 * | Metadata
 * |-----------------------------------------------------------------------------|
 * | This defines a rich object for the handling of Metadata in the application.
 * | This approach is used to avoid duplication and enable fluent additions of new
 * | metadata.
 * |-----------------------------------------------------------------------------|
 *
 * @property Collection<\App\Enums\Grade> $grades
 * @property Collection<\App\Enums\Standard> $standards
 * @property Collection<\App\Enums\Practice> $practices
 * @property Collection<\App\Enums\Language> $languages
 * @property \App\Enums\Category $category
 * @property \App\Enums\Audience $audience
 * |=============================================================================| */
class Metadata
{
    public Collection $grades;

    public Collection $standards;

    public Collection $practices;

    public Collection $languages;

    public Category $category;

    public Audience $audience;

    public function __construct(array $data)
    {
        $this->grades = $this->parseDataByKey('grades', $data, Grade::class);
        $this->languages = $this->parseDataByKey(
            'languages',
            $data,
            Language::class,
        );
        $this->practices = $this->parseDataByKey(
            'practices',
            $data,
            Practice::class,
        );
        $this->standards = $this->parseDataByKey(
            'standards',
            $data,
            Standard::class,
        );
        $this->category =
            array_key_exists('category', $data) &&
            ($category = Category::tryFrom($data['category']))
                ? $category
                : Category::material();
        $this->audience =
            array_key_exists('audience', $data) &&
            ($audience = Audience::tryFrom($data['audience']))
                ? $audience
                : Audience::students();
    }

    public function toArray()
    {
        return [
            'grades' => $this->grades
                ->map(fn ($value) => $value->value)
                ->toArray(),
            'languages' => $this->languages
                ->map(fn ($value) => $value->value)
                ->toArray(),
            'practices' => $this->practices
                ->map(fn ($value) => $value->value)
                ->toArray(),
            'standards' => $this->standards
                ->map(fn ($value) => $value->value)
                ->toArray(),
            'category' => $this->category->value,
            'audience' => $this->audience->value,
        ];
    }

    public function __toString()
    {
        return json_encode([
            'grades' => $this->grades
                ->map(fn ($value) => $value->value)
                ->toArray(),
            'languages' => $this->languages
                ->map(fn ($value) => $value->value)
                ->toArray(),
            'practices' => $this->practices
                ->map(fn ($value) => $value->value)
                ->toArray(),
            'standards' => $this->standards
                ->map(fn ($value) => $value->value)
                ->toArray(),
            'category' => $this->category->value,
            'audience' => $this->audience->value,
        ]);
    }

    public static function fromFaker($faker): self
    {
        $data = [
            'grades' => $faker->randomElements(
                Grade::toValues(),
                $faker->numberBetween(1, 3),
            ),
            'languages' => $faker->randomElements(
                Language::toValues(),
                $faker->numberBetween(1, 3),
            ),
            'standards' => $faker->randomElements(
                Standard::toValues(),
                $faker->numberBetween(1, 3),
            ),
            'practices' => $faker->randomElements(
                Practice::toValues(),
                $faker->numberBetween(1, 3),
            ),
            'category' => $faker->randomElement(Category::toValues()),
            'audience' => $faker->randomElement(Audience::toValues()),
        ];

        return new static($data);
    }

    /**
     * Parse the provided key data or return an empty array.
     *
     * @param  class-string  $enum
     */
    private function parseDataByKey(string $key, array $data, $enum)
    {
        return array_key_exists($key, $data)
            ? collect($data[$key])
                ->map(fn (string $value) => $enum::tryFrom($value))
                ->filter(fn ($value) => ! is_null($value))
            : collect([]);
    }
}
