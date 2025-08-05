<?php

namespace App\GraphQL\Queries;

use App\Models\Trip;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class TripQuery
{
    public function filter($_, array $args)
    {
        $query = Trip::query();

        if (isset($args['origin'])) {
            $query->where('origin', 'LIKE', '%' . $args['origin'] . '%');
        }

        if (isset($args['destination'])) {
            $query->where('destination', 'LIKE', '%' . $args['destination'] . '%');
        }

        if (isset($args['date'])) {
            $query->whereDate('date', $args['date']);
        }

        if (!empty($args['tagIds'])) {
            $query->whereHas('tags', function ($q) use ($args) {
                $q->whereIn('tags.id', $args['tagIds']);
            });
        }

        return $query->get();
    }

    public function userTravelStats($_, array $args): array
    {
        $user = Auth::user();

        // Publicados (el usuario es el conductor del vehículo asociado)
        $publishedTrips = Trip::whereHas('vehicle', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        // Reservados (el usuario hizo una reserva)
        $reservedTrips = Reservation::where('user_id', $user->id)->with('trip')->get();

        // Total de viajes
        $totalTrips = $publishedTrips->count() + $reservedTrips->count();

        // Distancia total recorrida (esto requiere una función para calcular distancia)
        $totalDistance = 0;
        foreach ($publishedTrips as $trip) {
            $totalDistance += $this->calculateDistance($trip->origin, $trip->destination);
        }
        foreach ($reservedTrips as $reservation) {
            $trip = $reservation->trip;
            if ($trip) {
                $totalDistance += $this->calculateDistance($trip->origin, $trip->destination);
            }
        }

        return [
            'totalTrips' => $totalTrips,
            'publishedTrips' => $publishedTrips->count(),
            'totalDistanceKm' => round($totalDistance, 2),
        ];
    }

    // Suponé que usás una tabla auxiliar o función para obtener la distancia en km entre dos ciudades.
    private function calculateDistance($origin, $destination): float
    {
        // Ejemplo simple (deberías reemplazar por una lógica real)
        $distances = [
            'Cordoba_Villa Carlos Paz' => 36.0,
            'Cordoba_Buenos Aires' => 700.0,
            'San Basilio_Villa Los Aromos' => 180.0,
            // ...
        ];

        $key = "{$origin}_{$destination}";
        return $distances[$key] ?? 100.0; // default 100 km si no se encuentra
    }
}
