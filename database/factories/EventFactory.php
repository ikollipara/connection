<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\Audience;
use App\Enums\Category;
use App\Enums\Grade;
use App\Enums\Practice;
use App\Enums\Standard;
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start_date = $this->faker->dateTime();
        $end_date = $this->faker->dateTimeBetween($start_date, '+5 days');
        return [
            //
            'title' => $this->faker->title(),
            'description'=> ['blocks' => []],
            'user_id'=> User::factory(),
            'start_date'=> $start_date,
            'end_date'=> $this->faker->boolean() ? $end_date : null,
            'start_time'=> null,
            'end_time'=> null,
            'metadata' => ['category' => $this->faker->randomElement(Category::cases()), 'audience' => $this->faker->randomElement(Audience::cases()), 'grades' => $this->faker->randomElements(Grade::cases()), 'standards' => $this->faker->randomElements(Standard::cases()), 'practices' => $this->faker->randomElements(Practice::cases())],
            'is_all_day'=> True,


        ];
    }

    public function hasEndDate()
    {
        return $this->state(function (array $attributes) {
            return [
                'end_date' => $this->faker->dateTimeBetween($attributes["start_date"], "+5 days"),
            ];
        });
    }
}
