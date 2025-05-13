<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommissionStoreRequest;
use App\Http\Requests\CommissionUpdateRequest;
use App\Http\Resources\CommissionCollection;
use App\Http\Resources\CommissionResource;
use App\Models\Commission;
use Illuminate\Http\Request;
use Dedoc\Scramble\Attributes\ExcludeRouteFromDocs;

class CommissionController extends Controller
{
    /**
     * Show Commission
     * 
     * Esta ruta nos trae la comision de la empresa.
     */
    public function index(Request $request)
    {
        $commissions = Commission::all();

        return new CommissionCollection($commissions);
    }

    /**
     * Create Commission
     * 
     * Esta ruta nos permite crear una nueva comission.
     */
    public function store(CommissionStoreRequest $request)
    {
        $commission = Commission::create($request->validated());

        return new CommissionResource($commission);
    }

    #[ExcludeRouteFromDocs]
    public function show(Request $request, Commission $commission)
    {
        return new CommissionResource($commission);
    }

    #[ExcludeRouteFromDocs]
    public function update(CommissionUpdateRequest $request, Commission $commission)
    {
        $commission->update($request->validated());

        return new CommissionResource($commission);
    }

    #[ExcludeRouteFromDocs]
    public function destroy(Request $request, Commission $commission)
    {
        $commission->delete();

        return response()->noContent();
    }
}
