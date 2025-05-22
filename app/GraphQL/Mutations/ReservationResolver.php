<?php

namespace App\GraphQL\Mutations;

use App\Models\Trip;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use GraphQL\Error\Error;

class ReservationMutator
{
    public function createReservation($_, array $args)
    {
        return DB::transaction(function () use ($args) {
            $trip = Trip::findOrFail($args['trip_id']);

            $requestedSeats = $args['seats'] ?? 1;

            if ($requestedSeats <= 0) {
                throw new Error('La cantidad de asientos debe ser al menos 1.');
            }

            if ($trip->available_seats < $requestedSeats) {
                throw new Error("Solo hay {$trip->available_seats} asientos disponibles.");
            }

            // Validar que el usuario no tenga ya una reserva
            if (Reservation::where('user_id', $args['user_id'])->where('trip_id', $args['trip_id'])->exists()) {
                throw new Error('Ya existe una reserva para este usuario en este viaje.');
            }

            // Crear la reserva
            $reservation = Reservation::create([
                'user_id' => $args['user_id'],
                'trip_id' => $args['trip_id'],
                'status' => $args['status'],
                'seats' => $requestedSeats,
            ]);

            // Descontar los asientos
            $trip->available_seats -= $requestedSeats;
            $trip->save();

            return $reservation;
        });
    }

    public function updateReservation($_, array $args)
    {
        return DB::transaction(function () use ($args) {
            $reservation = Reservation::findOrFail($args['id']);
            $trip = Trip::findOrFail($reservation->trip_id);

            $originalSeats = $reservation->seats;
            $newSeats = $args['seats'] ?? $originalSeats;

            // Si cambia la cantidad de asientos, ajustar los disponibles del trip
            if ($newSeats != $originalSeats) {
                $difference = $newSeats - $originalSeats;

                // Si se están pidiendo más asientos, verificar disponibilidad
                if ($difference > 0 && $trip->available_seats < $difference) {
                    throw new Error("Solo hay {$trip->available_seats} asientos disponibles.");
                }

                $trip->available_seats -= $difference;
                $trip->save();

                $reservation->seats = $newSeats;
            }

            if (isset($args['status'])) {
                $reservation->status = $args['status'];
            }

            $reservation->save();

            return $reservation;
        });
    }
}
