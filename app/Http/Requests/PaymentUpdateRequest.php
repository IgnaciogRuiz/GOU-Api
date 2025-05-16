<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentUpdateRequest extends FormRequest
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
            'transaction' => ['required', 'integer', 'unique:payments,transaction'],
            'reservation_id' => ['required', 'integer', 'exists:reservations,id'],
            'amount' => ['required', 'numeric', 'between:-99999999.99,99999999.99'],
            'payment_method' => ['required', 'in:cash,mercadopago'],
            'status' => ['required', 'in:pending,completed,failed'],
        ];
    }
}
