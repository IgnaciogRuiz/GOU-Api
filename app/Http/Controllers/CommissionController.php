<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommissionStoreRequest;
use App\Http\Requests\CommissionUpdateRequest;
use App\Http\Resources\CommissionCollection;
use App\Http\Resources\CommissionResource;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommissionController extends Controller
{
    public function index(Request $request): Response
    {
        $commissions = Commission::all();

        return new CommissionCollection($commissions);
    }

    public function store(CommissionStoreRequest $request): Response
    {
        $commission = Commission::create($request->validated());

        return new CommissionResource($commission);
    }

    public function show(Request $request, Commission $commission): Response
    {
        return new CommissionResource($commission);
    }

    public function update(CommissionUpdateRequest $request, Commission $commission): Response
    {
        $commission->update($request->validated());

        return new CommissionResource($commission);
    }

    public function destroy(Request $request, Commission $commission): Response
    {
        $commission->delete();

        return response()->noContent();
    }
}
