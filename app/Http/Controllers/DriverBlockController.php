<?php

namespace App\Http\Controllers;

use App\Http\Requests\DriverBlockStoreRequest;
use App\Http\Requests\DriverBlockUpdateRequest;
use App\Http\Resources\DriverBlockCollection;
use App\Http\Resources\DriverBlockResource;
use App\Models\DriverBlock;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DriverBlockController extends Controller
{

    /**
     * Show All Driver-Blocks
     * 
     * Trae todos los bloqueos de un usuario. 
     */
    public function index(Request $request)
    {
        $driverBlocks = DriverBlock::all();

        return new DriverBlockCollection($driverBlocks);
    }

    /**
     * Create Driver-Block
     * 
     * Crea el bloqueo de un usuario. 
     */
    public function store(DriverBlockStoreRequest $request)
    {
        $driverBlock = DriverBlock::create($request->validated());

        return new DriverBlockResource($driverBlock);
    }

    /**
     * Show Driver-Block 
     * 
     * Muestra un bloqueo especifico de un usuario. 
     */
    public function show(Request $request, DriverBlock $driverBlock)
    {
        return new DriverBlockResource($driverBlock);
    }

    /**
     * Update Driver-Block 
     * 
     * Actualiza un bloqueo especifico de un usuario. 
     */
    public function update(DriverBlockUpdateRequest $request, DriverBlock $driverBlock)
    {
        $driverBlock->update($request->validated());

        return new DriverBlockResource($driverBlock);
    }

    /**
     * Delete Driver-Block
     * 
     * Elimina un bloqueo especifico de un usuario. 
     */
    public function destroy(Request $request, DriverBlock $driverBlock)
    {
        $driverBlock->delete();

        return response()->noContent();
    }
}
