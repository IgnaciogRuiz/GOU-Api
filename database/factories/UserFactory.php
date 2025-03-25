<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'dni' => fake()->regexify('[A-Za-z0-9]{20}'),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'password' => fake()->password(),
            'validated' => fake()->boolean(),
            'cvu' => fake()->regexify('[A-Za-z0-9]{22}'),
            'pending_balance' => fake()->randomFloat(2, 0, 99999999.99),
        ];
    }
}
