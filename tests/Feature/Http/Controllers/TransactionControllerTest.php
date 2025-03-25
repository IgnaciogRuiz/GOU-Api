<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TransactionController
 */
final class TransactionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $transactions = Transaction::factory()->count(3)->create();

        $response = $this->get(route('transactions.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TransactionController::class,
            'store',
            \App\Http\Requests\TransactionControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $transaction = fake()->numberBetween(-10000, 10000);

        $response = $this->post(route('transactions.store'), [
            'transaction' => $transaction,
        ]);

        $transactions = Transaction::query()
            ->where('transaction', $transaction)
            ->get();
        $this->assertCount(1, $transactions);
        $transaction = $transactions->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $transaction = Transaction::factory()->create();

        $response = $this->get(route('transactions.show', $transaction));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TransactionController::class,
            'update',
            \App\Http\Requests\TransactionControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $transaction = Transaction::factory()->create();
        $transaction = fake()->numberBetween(-10000, 10000);

        $response = $this->put(route('transactions.update', $transaction), [
            'transaction' => $transaction,
        ]);

        $transaction->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($transaction, $transaction->transaction);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $transaction = Transaction::factory()->create();

        $response = $this->delete(route('transactions.destroy', $transaction));

        $response->assertNoContent();

        $this->assertModelMissing($transaction);
    }
}
