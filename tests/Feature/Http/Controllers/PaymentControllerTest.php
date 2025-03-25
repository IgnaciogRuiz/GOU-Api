<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PaymentController
 */
final class PaymentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $payments = Payment::factory()->count(3)->create();

        $response = $this->get(route('payments.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PaymentController::class,
            'store',
            \App\Http\Requests\PaymentControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $transaction = fake()->numberBetween(-10000, 10000);
        $reservation = Reservation::factory()->create();
        $amount = fake()->randomFloat(/** decimal_attributes **/);
        $payment_method = fake()->randomElement(/** enum_attributes **/);
        $payment_date = Carbon::parse(fake()->dateTime());
        $status = fake()->randomElement(/** enum_attributes **/);

        $response = $this->post(route('payments.store'), [
            'transaction' => $transaction,
            'reservation_id' => $reservation->id,
            'amount' => $amount,
            'payment_method' => $payment_method,
            'payment_date' => $payment_date->toDateTimeString(),
            'status' => $status,
        ]);

        $payments = Payment::query()
            ->where('transaction', $transaction)
            ->where('reservation_id', $reservation->id)
            ->where('amount', $amount)
            ->where('payment_method', $payment_method)
            ->where('payment_date', $payment_date)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $payments);
        $payment = $payments->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $payment = Payment::factory()->create();

        $response = $this->get(route('payments.show', $payment));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PaymentController::class,
            'update',
            \App\Http\Requests\PaymentControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $payment = Payment::factory()->create();
        $transaction = fake()->numberBetween(-10000, 10000);
        $reservation = Reservation::factory()->create();
        $amount = fake()->randomFloat(/** decimal_attributes **/);
        $payment_method = fake()->randomElement(/** enum_attributes **/);
        $payment_date = Carbon::parse(fake()->dateTime());
        $status = fake()->randomElement(/** enum_attributes **/);

        $response = $this->put(route('payments.update', $payment), [
            'transaction' => $transaction,
            'reservation_id' => $reservation->id,
            'amount' => $amount,
            'payment_method' => $payment_method,
            'payment_date' => $payment_date->toDateTimeString(),
            'status' => $status,
        ]);

        $payment->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($transaction, $payment->transaction);
        $this->assertEquals($reservation->id, $payment->reservation_id);
        $this->assertEquals($amount, $payment->amount);
        $this->assertEquals($payment_method, $payment->payment_method);
        $this->assertEquals($payment_date, $payment->payment_date);
        $this->assertEquals($status, $payment->status);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $payment = Payment::factory()->create();

        $response = $this->delete(route('payments.destroy', $payment));

        $response->assertNoContent();

        $this->assertModelMissing($payment);
    }
}
