<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'transaction' => fake()->regexify('[0-9]{20}'),
            'payment_id' => Payment::factory(),
            'driver_id' => User::factory(),
            'total_amount' => fake()->randomFloat(2, 0, 99999.99),
            'company_commission' => fake()->randomFloat(2, 0, 99999.99),
            'driver_final_amount' => fake()->randomFloat(2, 0, 99999.99),
            'transaction_date' => fake()->dateTime(),
            'status' => fake()->randomElement(["pending","processed","failed"]),
            'user_id' => User::factory(),
        ];
    } 
}
