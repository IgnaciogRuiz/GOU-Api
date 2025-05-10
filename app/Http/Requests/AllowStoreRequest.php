<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AllowStoreRequest extends FormRequest
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
            'tag_id' => ['required', 'integer', 'exists:tags,id'],
            'trip_id' => ['required', 'integer', 'exists:trips,id'],
        ];
    }
}
