<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
{
    $request->validate([
        'dni' => ['required', 'string', 'max:20', 'unique:'.User::class],
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'phone' => ['required', 'string', 'max:20'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'cvu' => ['nullable', 'string', 'max:50'],
    ]);

    $user = User::create([
        'dni' => $request->dni,
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->string('password')),
        'cvu' => $request->cvu,
        'validated' => false,
        'pending_balance' => 0
    ]);

    event(new Registered($user));

    Auth::login($user);

    return response()->noContent();
}
}
