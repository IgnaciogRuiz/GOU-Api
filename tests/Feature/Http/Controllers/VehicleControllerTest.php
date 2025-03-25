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
        $vehicles = Vehicle::factory()->count(3)->create();

        $response = $this->get(route('vehicles.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VehicleController::class,
            'store',
            \App\Http\Requests\VehicleControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $user = User::factory()->create();
        $brand = fake()->word();
        $model = fake()->word();
        $year = fake()->numberBetween(-10000, 10000);
        $license_plate = fake()->word();
        $dnrpa_approved = fake()->boolean();

        $response = $this->post(route('vehicles.store'), [
            'user_id' => $user->id,
            'brand' => $brand,
            'model' => $model,
            'year' => $year,
            'license_plate' => $license_plate,
            'dnrpa_approved' => $dnrpa_approved,
        ]);

        $vehicles = Vehicle::query()
            ->where('user_id', $user->id)
            ->where('brand', $brand)
            ->where('model', $model)
            ->where('year', $year)
            ->where('license_plate', $license_plate)
            ->where('dnrpa_approved', $dnrpa_approved)
            ->get();
        $this->assertCount(1, $vehicles);
        $vehicle = $vehicles->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->get(route('vehicles.show', $vehicle));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VehicleController::class,
            'update',
            \App\Http\Requests\VehicleControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $vehicle = Vehicle::factory()->create();
        $user = User::factory()->create();
        $brand = fake()->word();
        $model = fake()->word();
        $year = fake()->numberBetween(-10000, 10000);
        $license_plate = fake()->word();
        $dnrpa_approved = fake()->boolean();

        $response = $this->put(route('vehicles.update', $vehicle), [
            'user_id' => $user->id,
            'brand' => $brand,
            'model' => $model,
            'year' => $year,
            'license_plate' => $license_plate,
            'dnrpa_approved' => $dnrpa_approved,
        ]);

        $vehicle->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($user->id, $vehicle->user_id);
        $this->assertEquals($brand, $vehicle->brand);
        $this->assertEquals($model, $vehicle->model);
        $this->assertEquals($year, $vehicle->year);
        $this->assertEquals($license_plate, $vehicle->license_plate);
        $this->assertEquals($dnrpa_approved, $vehicle->dnrpa_approved);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->delete(route('vehicles.destroy', $vehicle));

        $response->assertNoContent();

        $this->assertModelMissing($vehicle);
    }
}
