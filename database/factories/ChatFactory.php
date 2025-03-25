<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Chat;
use App\Models\User;

class ChatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chat::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user1_id' => User::factory(),
            'user2_id' => User::factory(),
            'creation_date' => fake()->dateTime(),
            'user_id' => User::factory(),
        ];
    }
}
