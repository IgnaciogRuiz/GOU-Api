<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\DriverBlock;
use App\Models\User;

class DriverBlockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DriverBlock::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'driver_id' => User::factory(),
            'reason' => fake()->text(),
            'block_date' => fake()->dateTime(),
            'status' => fake()->randomElement(["active","removed"]),
            'user_id' => User::factory(),
        ];
    }
}
