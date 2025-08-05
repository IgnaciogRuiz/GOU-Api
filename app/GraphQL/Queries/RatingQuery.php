<?php

namespace App\GraphQL\Queries;

use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingQuery
{
    /**
     * Devuelve todos los ratings del usuario autenticado
     */
    public function userRatings($_, array $args)
    {
        $user = Auth::user();

        return Rating::where('user_id', $user->id)->orWhere('driver_id', $user->id)->get();
    }

    /**
     * Devuelve el ratio promedio de todos los ratings del usuario autenticado
     */
    public function userRatingRatio($_, array $args): float
    {
        $user = Auth::user();

        $ratings = Rating::where('user_id', $user->id)
            ->orWhere('driver_id', $user->id)
            ->pluck('rating');

        if ($ratings->isEmpty()) {
            return 0;
        }

        return round($ratings->avg(), 1); // ej: 8.6
    }
}
