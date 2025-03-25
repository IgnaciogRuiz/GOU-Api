<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'dni' => ['required', 'string', 'max:20', 'unique:users,dni'],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'password', 'max:255'],
            'validated' => ['required'],
            'cvu' => ['required', 'string', 'max:22', 'unique:users,cvu'],
            'pending_balance' => ['required', 'numeric', 'between:-99999999.99,99999999.99'],
        ];
    }
}
