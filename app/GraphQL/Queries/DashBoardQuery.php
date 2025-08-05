<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Vehicle;
use Carbon\Carbon;

class DashboardQuery
{
    public function data($_, array $args)
    {
        $user = Auth::user();

        if (!$user) {
            return [
                'profile_photo' => null,
                'reservations' => collect(),
                'published_trips' => collect(),
                'recent_activity' => collect(),
            ];
        }

        // Obtener reservas del usuario usando consulta directa
        $reservations = Reservation::where('user_id', $user->id)
            ->with([
                'trip.vehicle.user'
            ])
            ->get();

        // Obtener vehículos del usuario usando consulta directa
        $userVehicles = Vehicle::where('user_id', $user->id)
            ->with([
                'trips.reservations.user'
            ])
            ->get();

        // Extraer todos los trips de los vehículos del usuario
        $publishedTrips = collect();
        foreach ($userVehicles as $vehicle) {
            if ($vehicle->trips) {
                foreach ($vehicle->trips as $trip) {
                    $publishedTrips->push($trip);
                }
            }
        }

        // Actividad reciente
        $activity = collect();

        // Actividad de trips como conductor
        foreach ($publishedTrips as $trip) {
            if ($trip->reservations) {
                foreach ($trip->reservations as $reservation) {
                    if ($reservation->status === 'completed' && $reservation->user) {
                        $isUserReservation = $reservation->user_id === $user->id;

                        $activity->push([
                            'title' => $isUserReservation ? 'Trip completed' : 'New passenger joined',
                            'description' => $isUserReservation
                                ? "{$trip->origin} → {$trip->destination} completed"
                                : "{$reservation->user->firstname} completed your {$trip->origin} → {$trip->destination} trip",
                            'time' => $trip->date ? Carbon::parse($trip->date)->diffForHumans() : 'Unknown time',
                            'icon' => $isUserReservation ? 'check' : 'user-plus',
                            'iconColor' => $isUserReservation ? '#10B981' : '#3B82F6',
                        ]);
                    }
                }
            }
        }

        // Actividad de reservas como pasajero
        foreach ($reservations as $reservation) {
            if ($reservation->status === 'completed' && $reservation->trip) {
                $activity->push([
                    'title' => 'Trip completed as passenger',
                    'description' => "Completed trip from {$reservation->trip->origin} → {$reservation->trip->destination}",
                    'time' => $reservation->trip->date ? Carbon::parse($reservation->trip->date)->diffForHumans() : 'Unknown time',
                    'icon' => 'check-circle',
                    'iconColor' => '#059669',
                ]);
            }
        }

        // Ordenar actividad por fecha más reciente y limitar
        $activity = $activity->take(10);

        return [
            'profile_photo' => $user->profile_photo ?? null,
            'reservations' => $reservations,
            'published_trips' => $publishedTrips,
            'recent_activity' => $activity->values(),
        ];
    }
}
