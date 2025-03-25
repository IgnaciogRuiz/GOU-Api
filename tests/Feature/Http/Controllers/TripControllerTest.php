<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TripController
 */
final class TripControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $trips = Trip::factory()->count(3)->create();

        $response = $this->get(route('trips.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TripController::class,
            'store',
            \App\Http\Requests\TripControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $vehicle = Vehicle::factory()->create();
        $origin = fake()->word();
        $destination = fake()->word();
        $date = Carbon::parse(fake()->dateTime());
        $available_seats = fake()->numberBetween(-10000, 10000);
        $price = fake()->randomFloat(/** decimal_attributes **/);
        $status = fake()->randomElement(/** enum_attributes **/);

        $response = $this->post(route('trips.store'), [
            'vehicle_id' => $vehicle->id,
            'origin' => $origin,
            'destination' => $destination,
            'date' => $date->toDateTimeString(),
            'available_seats' => $available_seats,
            'price' => $price,
            'status' => $status,
        ]);

        $trips = Trip::query()
            ->where('vehicle_id', $vehicle->id)
            ->where('origin', $origin)
            ->where('destination', $destination)
            ->where('date', $date)
            ->where('available_seats', $available_seats)
            ->where('price', $price)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $trips);
        $trip = $trips->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $trip = Trip::factory()->create();

        $response = $this->get(route('trips.show', $trip));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TripController::class,
            'update',
            \App\Http\Requests\TripControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $trip = Trip::factory()->create();
        $vehicle = Vehicle::factory()->create();
        $origin = fake()->word();
        $destination = fake()->word();
        $date = Carbon::parse(fake()->dateTime());
        $available_seats = fake()->numberBetween(-10000, 10000);
        $price = fake()->randomFloat(/** decimal_attributes **/);
        $status = fake()->randomElement(/** enum_attributes **/);

        $response = $this->put(route('trips.update', $trip), [
            'vehicle_id' => $vehicle->id,
            'origin' => $origin,
            'destination' => $destination,
            'date' => $date->toDateTimeString(),
            'available_seats' => $available_seats,
            'price' => $price,
            'status' => $status,
        ]);

        $trip->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($vehicle->id, $trip->vehicle_id);
        $this->assertEquals($origin, $trip->origin);
        $this->assertEquals($destination, $trip->destination);
        $this->assertEquals($date, $trip->date);
        $this->assertEquals($available_seats, $trip->available_seats);
        $this->assertEquals($price, $trip->price);
        $this->assertEquals($status, $trip->status);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $trip = Trip::factory()->create();

        $response = $this->delete(route('trips.destroy', $trip));

        $response->assertNoContent();

        $this->assertModelMissing($trip);
    }
}
