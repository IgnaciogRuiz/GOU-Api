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
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Support\Facades\Log;

#[Group('Register')]
class RegisteredUserController extends Controller
{
    /**
     * Registration Request.
     * 
     * Esta ruta se encarga de manejar las solicitudes de registro. Posterior a ellas existen las RegisterVerifications para ahorrar error en la request.
     * @unauthenticated
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'dni' => ['required', 'string', 'max:20', 'unique:' . User::class],
            'photo' => 'nullable|image|max:2048',
            'firstname' => ['required', 'string', 'max:100'],
            'lastname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'cvu' => ['nullable', 'string', 'max:50'],
        ]);

        // Subida de imagen si existe
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $user = User::create([
            'profile_photo' => $photoPath,
            'dni' => $request->dni,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->input('password')),
            'cvu' => $request->cvu,
            'validated' => false,
            'pending_balance' => 0,
        ]);


        event(new Registered($user));

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'user' => $user,
            'path' => $photoPath,
        ], 201);
    }
}
