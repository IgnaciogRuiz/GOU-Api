<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'vehicle_id' => $this->vehicle_id,
            'origin' => $this->origin,
            'destination' => $this->destination,
            'date' => $this->date,
            'available_seats' => $this->available_seats,
            'price' => $this->price,
            'ratings' => RatingCollection::make($this->whenLoaded('ratings')),
            'vehicle' => VehicleResource::make($this->whenLoaded('vehicle')),
        ];
    }
}
