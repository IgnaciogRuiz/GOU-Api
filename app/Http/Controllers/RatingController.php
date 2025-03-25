<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingStoreRequest;
use App\Http\Requests\RatingUpdateRequest;
use App\Http\Resources\RatingCollection;
use App\Http\Resources\RatingResource;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        $ratings = Rating::all();

        return new RatingCollection($ratings);
    }

    public function store(RatingStoreRequest $request)
    {
        $rating = Rating::create($request->validated());

        return new RatingResource($rating);
    }

    public function show(Request $request, Rating $rating)
    {
        return new RatingResource($rating);
    }

    public function update(RatingUpdateRequest $request, Rating $rating)
    {
        $rating->update($request->validated());

        return new RatingResource($rating);
    }

    public function destroy(Request $request, Rating $rating)
    {
        $rating->delete();

        return response()->noContent();
    }
}
