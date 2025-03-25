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
    public function index(Request $request)
    {
        $trips = Trip::all();

        return new TripCollection($trips);
    }

    public function store(TripStoreRequest $request)
    {
        $trip = Trip::create($request->validated());

        return new TripResource($trip);
    }

    public function show(Request $request, Trip $trip)
    {
        return new TripResource($trip);
    }

    public function update(TripUpdateRequest $request, Trip $trip)
    {
        $trip->update($request->validated());

        return new TripResource($trip);
    }

    public function destroy(Request $request, Trip $trip)
    {
        $trip->delete();

        return response()->noContent();
    }
}
