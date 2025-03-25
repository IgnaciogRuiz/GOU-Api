<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverBlockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'driver_id' => $this->driver_id,
            'reason' => $this->reason,
            'block_date' => $this->block_date,
            'status' => $this->status,
            'user_id' => $this->user_id,
        ];
    }
}
