<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'dni' => $this->dni,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'validated' => $this->validated,
            'cvu' => $this->cvu,
            'pending_balance' => $this->pending_balance,
            'driverBlocks' => DriverBlockCollection::make($this->whenLoaded('driverBlocks')),
        ];
    }
}
