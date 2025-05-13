<?php

namespace App\Http\Controllers;

use App\Http\Requests\TripStoreRequest;
use App\Http\Requests\TripUpdateRequest;
use App\Http\Resources\TripCollection;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TripController extends Controller
{
    /**
     * Show All Trips
     * 
     * Muestra todos los viajes.
     */
    public function index(Request $request)
    {
        $trips = Trip::all();

        return new TripCollection($trips);
    }

    /**
     * Create Trip
     * 
     * Crea un viaje.
     */
    public function store(TripStoreRequest $request)
    {
        $trip = Trip::create($request->validated());

        return new TripResource($trip);
    }

    /**
     * Show Trip
     * 
     * Muestra un viaje especifico.
     */
    public function show(Request $request, Trip $trip)
    {
        return new TripResource($trip);
    }

    /**
     * Update Trip
     * 
     * Actualiza un viaje especifico.
     */
    public function update(TripUpdateRequest $request, Trip $trip)
    {
        $trip->update($request->validated());

        return new TripResource($trip);
    }

     /**
     * Delete Trip
     * 
     * Elimina un viaje especifico.
     */
    public function destroy(Request $request, Trip $trip)
    {
        $trip->delete();

        return response()->noContent();
    }
}
