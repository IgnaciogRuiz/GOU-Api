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
        // Intentar autenticar al usuario con DNI y contraseña
        $request->authenticate();

        // Obtener el usuario autenticado
        $user = User::where('dni', $request->input('dni'))->firstOrFail();

        // Generar el token de acceso
        $token = $user->createToken('GOU')->plainTextToken;

        // Retornar el token en la respuesta
        return response()->json(['token' => $token]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        // Invalidar el token actual
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->noContent();
    }
}

