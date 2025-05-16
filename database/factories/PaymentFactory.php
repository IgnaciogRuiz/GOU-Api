<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Payment;
use App\Models\Reservation;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'transaction' => fake()->regexify('[0-9]{20}'),
            'reservation_id' => Reservation::factory(),
            'amount' => fake()->randomFloat(2, 0, 99999.99),
            'payment_method' => fake()->randomElement(["cash", "mercadopago"]),
            'status' => fake()->randomElement(["pending", "completed", "failed"]),
        ];
    }
}
