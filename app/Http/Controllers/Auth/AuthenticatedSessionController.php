<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Dedoc\Scramble\Attributes\Group;

#[Group('Auth')]
class AuthenticatedSessionController extends Controller
{
    /**
     * Login Request
     * 
     * Esta ruta maneja las peticiones entrantes de autenticacion. No requiere BearerToken
     * @unauthenticated
     */
    public function store(LoginRequest $request)
    {

        $request->authenticate();

        $user = User::where('dni', $request->input('dni'))->firstOrFail();

        // Eliminar tokens anteriores de este mismo device (opcional)
        $user->tokens()->where('name', $request->device_name)->delete();

        // Generar un token nuevo con el nombre del dispositivo
        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'user_id' => $user->id,
            'token' => $token,
        ]);
    }

    /**
     * Logout Request
     * 
     * Destruye el BearerToken de la session.
     */
    public function destroy(Request $request)
    {
        // Invalidar el token actual
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
