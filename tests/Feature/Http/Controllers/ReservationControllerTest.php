<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Reservation;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ReservationController
 */
final class ReservationControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $reservations = Reservation::factory()->count(3)->create();

        $response = $this->get(route('reservations.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ReservationController::class,
            'store',
            \App\Http\Requests\ReservationControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $user = User::factory()->create();
        $trip = Trip::factory()->create();
        $status = fake()->randomElement(/** enum_attributes **/);
        $reservation_date = Carbon::parse(fake()->dateTime());

        $response = $this->post(route('reservations.store'), [
            'user_id' => $user->id,
            'trip_id' => $trip->id,
            'status' => $status,
            'reservation_date' => $reservation_date->toDateTimeString(),
        ]);

        $reservations = Reservation::query()
            ->where('user_id', $user->id)
            ->where('trip_id', $trip->id)
            ->where('status', $status)
            ->where('reservation_date', $reservation_date)
            ->get();
        $this->assertCount(1, $reservations);
        $reservation = $reservations->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $reservation = Reservation::factory()->create();

        $response = $this->get(route('reservations.show', $reservation));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ReservationController::class,
            'update',
            \App\Http\Requests\ReservationControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $reservation = Reservation::factory()->create();
        $user = User::factory()->create();
        $trip = Trip::factory()->create();
        $status = fake()->randomElement(/** enum_attributes **/);
        $reservation_date = Carbon::parse(fake()->dateTime());

        $response = $this->put(route('reservations.update', $reservation), [
            'user_id' => $user->id,
            'trip_id' => $trip->id,
            'status' => $status,
            'reservation_date' => $reservation_date->toDateTimeString(),
        ]);

        $reservation->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($user->id, $reservation->user_id);
        $this->assertEquals($trip->id, $reservation->trip_id);
        $this->assertEquals($status, $reservation->status);
        $this->assertEquals($reservation_date, $reservation->reservation_date);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $reservation = Reservation::factory()->create();

        $response = $this->delete(route('reservations.destroy', $reservation));

        $response->assertNoContent();

        $this->assertModelMissing($reservation);
    }
}
