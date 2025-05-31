<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingStoreRequest;
use App\Http\Requests\RatingUpdateRequest;
use App\Http\Resources\RatingCollection;
use App\Http\Resources\RatingResource;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Dedoc\Scramble\Attributes\ExcludeAllRoutesFromDocs;

#[ExcludeAllRoutesFromDocs]


class RatingController extends Controller
{
    /**
     * Show All Ratings
     * 
     * Muestra todos los ratings de un usuario especifico
     */

    public function index(Request $request)
    {
        $ratings = Rating::all();

        return new RatingCollection($ratings);
    }

    /**
     * Create Rating
     * 
     * Crea un rating de un usuario especifico
     */

    public function store(RatingStoreRequest $request)
    {
        $rating = Rating::create($request->validated());

        return new RatingResource($rating);
    }

    /**
     * Show Rating
     * 
     * Muestra un rating especifico de un usuario especifico
     */

    public function show(Request $request, Rating $rating)
    {
        return new RatingResource($rating);
    }

    /**
     * Update Rating
     * 
     * Actualiza un rating especifico de un usuario especifico
     */

    public function update(RatingUpdateRequest $request, Rating $rating)
    {
        $rating->update($request->validated());

        return new RatingResource($rating);
    }

    /**
     * Delete Rating
     * 
     * Elimina un rating especifico de un usuario especifico
     */

    public function destroy(Request $request, Rating $rating)
    {
        $rating->delete();

        return response()->noContent();
    }
}
