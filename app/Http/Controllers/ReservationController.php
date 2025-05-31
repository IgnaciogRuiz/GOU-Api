<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationStoreRequest;
use App\Http\Requests\ReservationUpdateRequest;
use App\Http\Resources\ReservationCollection;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Dedoc\Scramble\Attributes\ExcludeAllRoutesFromDocs;

#[ExcludeAllRoutesFromDocs]

class ReservationController extends Controller
{
    /**
     * Show All Reservations
     * 
     * Muestra todas las reservas de un usuario especifico
     */

    public function index(Request $request)
    {
        $reservations = Reservation::all();

        return new ReservationCollection($reservations);
    }

    /**
     * Create Reservation
     * 
     * Crea una reserva de un viaje
     */

    public function store(ReservationStoreRequest $request)
    {
        $reservation = Reservation::create($request->validated());

        return new ReservationResource($reservation);
    }

    /**
     * Show Reservation
     * 
     * Muestra una reserva especifica de un usuario especifico
     */

    public function show(Request $request, Reservation $reservation)
    {
        return new ReservationResource($reservation);
    }

    /**
     * Update Reservation
     * 
     * Actualiza una reserva especifica
     */

    public function update(ReservationUpdateRequest $request, Reservation $reservation)
    {
        $reservation->update($request->validated());

        return new ReservationResource($reservation);
    }

    /**
     * Delete Reservation
     * 
     * Elimina una Reservation
     */

    public function destroy(Request $request, Reservation $reservation)
    {
        $reservation->delete();

        return response()->noContent();
    }
}
