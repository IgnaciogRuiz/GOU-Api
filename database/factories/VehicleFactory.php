<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Vehicle;

class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'brand' => fake()->regexify('[A-Za-z0-9]{50}'),
            'model' => fake()->regexify('[A-Za-z0-9]{50}'),
            'year' => fake()->numberBetween(-10000, 10000),
            'license_plate' => fake()->regexify('[A-Za-z0-9]{10}'),
            'dnrpa_approved' => fake()->boolean(),
        ];
    }
}
