<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tag_id' => $this->tag_id,
            'trip_id' => $this->trip_id,
            'trip' => TripResource::make($this->whenLoaded('trip')),
        ];
    }
}
