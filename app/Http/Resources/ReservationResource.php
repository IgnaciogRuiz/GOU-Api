<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'trip_id' => $this->trip_id,
            'status' => $this->status,
            'trip' => TripResource::make($this->whenLoaded('trip')),
            'payment' => PaymentResource::make($this->whenLoaded('payment')),
        ];
    }
}
