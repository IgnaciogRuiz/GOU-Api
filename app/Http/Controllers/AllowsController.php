<?php

namespace App\Http\Controllers;

use App\Http\Requests\AllowStoreRequest;
use App\Http\Requests\AllowUpdateRequest;
use App\Http\Resources\AllowCollection;
use App\Http\Resources\AllowResource;
use App\Models\Allows;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AllowsController extends Controller
{
    /**
     * Show All Allows 
     * 
     * Esta ruta nos permite traer todos los elementos de la tabla itermedia Allow.
     */
    public function index(Request $request)
    {
        $allows = Allows::all();

        return new AllowCollection($allows);
    }


    /**
     * Create Allow
     * 
     * Esta ruta nos permite crear una relacion entre una "Tag" y un "trip".
     */
    public function store(AllowStoreRequest $request)
    {
        $allow = Allows::create($request->validated());

        return new AllowResource($allow);
    }

    /**
     * Show Allow
     * 
     * Esta ruta nos permite ver 1 fila especifica de la tabla.
     */
    public function show(Request $request, Allows $allow)
    {
        return new AllowResource($allow);
    }

    /**
     * Update Allow
     * 
     * Esta ruta nos permite actualizar una fila de la tabla.
     */
    public function update(AllowUpdateRequest $request, Allows $allow)
    {
        $allow->update($request->validated());

        return new AllowResource($allow);
    }

    /**
     * Delete Allow
     * 
     * Esta ruta destruye una fila de la tabla.
     */
    public function destroy(Request $request, Allows $allow)
    {
        $allow->delete();

        return response()->noContent();
    }
}
