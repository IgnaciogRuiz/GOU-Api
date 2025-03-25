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
            'company_commission' => $this->company_commission,
            'driver_final_amount' => $this->driver_final_amount,
            'transaction_date' => $this->transaction_date,
            'status' => $this->status,
            'user_id' => $this->user_id,
        ];
    }
}
