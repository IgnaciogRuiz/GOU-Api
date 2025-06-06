<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverBlockUpdateRequest extends FormRequest
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
            'reason' => ['required', 'string'],
            'status' => ['required', 'in:active,removed'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
