<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleStoreRequest;
use App\Http\Requests\VehicleUpdateRequest;
use App\Http\Resources\VehicleCollection;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VehicleController extends Controller
{
    /**
     * Show All Vehicles
     * 
     * Muestra todos los vehiculos.
     */
    public function index(Request $request)
    {
        $vehicles = Vehicle::all();

        return new VehicleCollection($vehicles);
    }

    /**
     * Create Vehicle
     * 
     * Crea un vehiculo.
     */
    public function store(VehicleStoreRequest $request)
    {
        $vehicle = Vehicle::create($request->validated());

        return new VehicleResource($vehicle);
    }

    /**
     * Show Vehicle
     * 
     * Muestra un vehiculo especifico.
     */
    public function show(Request $request, Vehicle $vehicle)
    {
        return new VehicleResource($vehicle);
    }

    /**
     * Update Vehicle
     * 
     * Actualiza un vehiculo especifico.
     */
    public function update(VehicleUpdateRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());

        return new VehicleResource($vehicle);
    }

    /**
     * Delete Vehicle
     * 
     * Elimina un vehiculo especifico.
     */
    public function destroy(Request $request, Vehicle $vehicle)
    {
        $vehicle->delete();

        return response()->noContent();
    }
}
