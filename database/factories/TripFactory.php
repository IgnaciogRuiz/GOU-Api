<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Trip;
use App\Models\Vehicle;

class TripFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trip::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::factory(),
            'origin' => fake()->regexify('[A-Za-z0-9]{255}'),
            'destination' => fake()->regexify('[A-Za-z0-9]{255}'),
            'date' => fake()->dateTime(),
            'available_seats' => fake()->numberBetween(-10000, 10000),
            'price' => fake()->randomFloat(2, 0, 99999999.99),
            'status' => fake()->randomElement(["pending","in_progress","completed","canceled"]),
        ];
    }
}
