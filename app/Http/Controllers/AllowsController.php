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
    public function index(Request $request)
    {
        $allows = Allows::all();

        return new AllowCollection($allows);
    }

    public function store(AllowStoreRequest $request)
    {
        $allow = Allows::create($request->validated());

        return new AllowResource($allow);
    }

    public function show(Request $request, Allows $allow)
    {
        return new AllowResource($allow);
    }

    public function update(AllowUpdateRequest $request, Allows $allow)
    {
        $allow->update($request->validated());

        return new AllowResource($allow);
    }

    public function destroy(Request $request, Allows $allow)
    {
        $allow->delete();

        return response()->noContent();
    }
}
