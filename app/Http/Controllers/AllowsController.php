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
        $allows = Allow::all();

        return new AllowCollection($allows);
    }

    public function store(AllowStoreRequest $request)
    {
        $allow = Allow::create($request->validated());

        return new AllowResource($allow);
    }

    public function show(Request $request, Allow $allow)
    {
        return new AllowResource($allow);
    }

    public function update(AllowUpdateRequest $request, Allow $allow)
    {
        $allow->update($request->validated());

        return new AllowResource($allow);
    }

    public function destroy(Request $request, Allow $allow)
    {
        $allow->delete();

        return response()->noContent();
    }
}
