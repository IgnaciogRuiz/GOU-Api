<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'transaction' => $this->transaction,
            'payment_id' => $this->payment_id,
            'driver_id' => $this->driver_id,
            'total_amount' => $this->total_amount,
            'company_final_amount' => $this->company_final_amount,
            'status' => $this->status,
            'user_id' => $this->user_id,
        ];
    }
}
