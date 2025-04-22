<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {

        $request->authenticate();

        $user = User::where('dni', $request->input('dni'))->firstOrFail();

        // Eliminar tokens anteriores de este mismo device (opcional)
        $user->tokens()->where('name', $request->device_name)->delete();

        // Generar un token nuevo con el nombre del dispositivo
        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json(['token' => $token]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        // Invalidar el token actual
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}

