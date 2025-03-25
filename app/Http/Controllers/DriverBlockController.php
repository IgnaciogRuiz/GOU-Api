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
    public function index(Request $request)
    {
        $driverBlocks = DriverBlock::all();

        return new DriverBlockCollection($driverBlocks);
    }

    public function store(DriverBlockStoreRequest $request)
    {
        $driverBlock = DriverBlock::create($request->validated());

        return new DriverBlockResource($driverBlock);
    }

    public function show(Request $request, DriverBlock $driverBlock)
    {
        return new DriverBlockResource($driverBlock);
    }

    public function update(DriverBlockUpdateRequest $request, DriverBlock $driverBlock)
    {
        $driverBlock->update($request->validated());

        return new DriverBlockResource($driverBlock);
    }

    public function destroy(Request $request, DriverBlock $driverBlock)
    {
        $driverBlock->delete();

        return response()->noContent();
    }
}
