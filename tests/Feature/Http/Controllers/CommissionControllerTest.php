<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Commission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CommissionController
 */
final class CommissionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $commissions = Commission::factory()->count(3)->create();

        $response = $this->get(route('commissions.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommissionController::class,
            'store',
            \App\Http\Requests\CommissionControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $value = fake()->randomFloat(/** decimal_attributes **/);

        $response = $this->post(route('commissions.store'), [
            'value' => $value,
        ]);

        $commissions = Commission::query()
            ->where('value', $value)
            ->get();
        $this->assertCount(1, $commissions);
        $commission = $commissions->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $commission = Commission::factory()->create();

        $response = $this->get(route('commissions.show', $commission));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommissionController::class,
            'update',
            \App\Http\Requests\CommissionControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $commission = Commission::factory()->create();
        $value = fake()->randomFloat(/** decimal_attributes **/);

        $response = $this->put(route('commissions.update', $commission), [
            'value' => $value,
        ]);

        $commission->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($value, $commission->value);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $commission = Commission::factory()->create();

        $response = $this->delete(route('commissions.destroy', $commission));

        $response->assertNoContent();

        $this->assertModelMissing($commission);
    }
}
