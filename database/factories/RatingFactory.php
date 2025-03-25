<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Rating;
use App\Models\Trip;
use App\Models\User;

class RatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rating::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'trip_id' => Trip::factory(),
            'user_id' => User::factory(),
            'driver_id' => User::factory(),
            'rating' => fake()->numberBetween(-10000, 10000),
            'comment' => fake()->text(),
            'rating_date' => fake()->dateTime(),
        ];
    }
}
