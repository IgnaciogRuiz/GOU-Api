<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\VehicleController
 */
final class VehicleControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $user = User::factory()->create();

        $vehicles = Vehicle::factory()->count(3)->create();

        $response = $this->getJson(route('vehicles.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'user_id', 'brand', 'model', 'year', 'license_plate', 'dnrpa_approved']
            ]
        ]);
    }

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VehicleController::class,
            'store',
            \App\Http\Requests\VehicleStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $user = User::factory()->create();

        $data = [
            'user_id' => $user->id,
            'brand' => fake()->word(),
            'model' => fake()->word(),
            'year' => fake()->numberBetween(2000, 2025),
            'license_plate' => strtoupper(fake()->unique()->bothify('???###')),
            'dnrpa_approved' => true,
        ];

        $response = $this->postJson(route('vehicles.store'), $data);

        $response->assertCreated();
        $this->assertDatabaseHas('vehicles', [
            'license_plate' => $data['license_plate'],
        ]);
    }

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $user = User::factory()->create();

        $vehicle = Vehicle::factory()->create();

        $response = $this->getJson(route('vehicles.show', $vehicle));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['id', 'user_id', 'brand', 'model', 'year', 'license_plate', 'dnrpa_approved']
        ]);
    }

    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VehicleController::class,
            'update',
            \App\Http\Requests\VehicleUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $user = User::factory()->create();

        $vehicle = Vehicle::factory()->create();
        $newUser = User::factory()->create();

        $data = [
            'user_id' => $newUser->id,
            'brand' => fake()->word(),
            'model' => fake()->word(),
            'year' => 2023,
            'license_plate' => strtoupper(fake()->unique()->bothify('???###')),
            'dnrpa_approved' => false,
        ];

        $response = $this->putJson(route('vehicles.update', $vehicle), $data);

        $response->assertOk();

        $vehicle->refresh();
        $this->assertEquals($data['brand'], $vehicle->brand);
        $this->assertEquals($data['model'], $vehicle->model);
        $this->assertEquals($data['year'], $vehicle->year);
        $this->assertEquals($data['license_plate'], $vehicle->license_plate);
        $this->assertEquals($data['dnrpa_approved'], $vehicle->dnrpa_approved);
    }

    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $user = User::factory()->create();

        $vehicle = Vehicle::factory()->create();

        $response = $this->deleteJson(route('vehicles.destroy', $vehicle));

        $response->assertNoContent();
        $this->assertModelMissing($vehicle);
    }
}
