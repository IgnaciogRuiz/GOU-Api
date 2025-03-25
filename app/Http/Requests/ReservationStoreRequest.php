<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users.id,id'],
            'trip_id' => ['required', 'integer', 'exists:trips.id,id'],
            'status' => ['required', 'in:pending,confirmed,canceled'],
            'reservation_date' => ['required'],
        ];
    }
}
