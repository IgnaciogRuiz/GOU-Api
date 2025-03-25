<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'transaction' => $this->transaction,
            'reservation_id' => $this->reservation_id,
            'amount' => $this->amount,
            'payment_method' => $this->payment_method,
            'payment_date' => $this->payment_date,
            'status' => $this->status,
            'reservation' => ReservationResource::make($this->whenLoaded('reservation')),
            'transaction' => TransactionResource::make($this->whenLoaded('transaction')),
        ];
    }
}
