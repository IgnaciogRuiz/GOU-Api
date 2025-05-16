<?php

namespace App\GraphQL\Mutations;

use Carbon\Carbon;
use App\Models\Trip;

class TripResolver
{
    public function createTrip($_, array $args)
    {
        $input = $args['input'];

        $tagIds = $input['tagIds'] ?? [];
        unset($input['tagIds']); // porque esa columna no existe en la tabla `trips`

        $trip = Trip::create($input); // crea el viaje

        if (!empty($tagIds)) {
            $trip->tags()->sync($tagIds); // mete los IDs en la tabla `allows`
        }

        return $trip;
    }

    public function updateTrip($_, array $args)
    {
        $input = $args['input'];

        $trip = Trip::findOrFail($input['id']);

        if (isset($input['date'])) {
            $input['date'] = Carbon::parse($input['date']);
        }

        $tagIds = $input['tagIds'] ?? null;
        unset($input['tagIds'], $input['id']);

        // Actualizamos solo los campos que vienen
        $trip->update($input);

        // Si mandan tagIds, sincronizamos la relación
        if (is_array($tagIds)) {
            $trip->tags()->sync($tagIds);
        }

        return $trip;
    }

    public function deleteTrip($_, array $args)
    {
        $trip = Trip::find($args['id']);
        if (!$trip) {
            return false;
        }

        // Primero desvinculamos todas las relaciones de tags para no violar la FK
        $trip->tags()->detach();

        // Ahora sí borramos el trip
        return $trip->delete();
    }
}
