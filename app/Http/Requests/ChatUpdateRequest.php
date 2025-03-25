<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatUpdateRequest extends FormRequest
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
            'user1_id' => ['required', 'integer', 'exists:users.id,id'],
            'user2_id' => ['required', 'integer', 'exists:users.id,id'],
            'creation_date' => ['required'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
