<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EmailVerificationCodeNotification;
use Twilio\Rest\Client;

class RegisterVerificationController extends Controller
{
    // Verificar si el email es único
    public function verifyEmail(Request $request) {
        $request->validate(['email' => 'required|email|unique:users,email']);

        $emailCode = mt_rand(100000, 999999); // Código de 6 dígitos
    
        DB::table('email_verifications')->updateOrInsert(
            ['email' => $request->email],
            [
                'code' => $emailCode,
                'expires_at' => now()->addMinutes(60),
                'updated_at' => now(),
            ]
        );

            // Crear un "notifiable" falso para enviar la notificación sin tener un usuario
            $notifiable = new \stdClass();  // Usamos un objeto estándar para el correo
            $notifiable->email = $request->email;

            // Enviar la notificación personalizada al correo proporcionado
            Notification::route('mail', $request->email)
                        ->notify(new EmailVerificationCodeNotification($emailCode));

            return response()->json(['message' => 'Código enviado al correo']);
    }

    public function verifyEmailToken(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6'
        ]);

        $verification = DB::table('email_verifications')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            return response()->json(['message' => 'Código inválido o expirado'], 422);
        }

        DB::table('email_verifications')->where('email', $request->email)->delete();
        return response()->json(['message' => 'Email verificado correctamente']);
    }

    // Verificar si el celular es único
    public function verifyPhone(Request $request) {
        $request->validate(['phone' => 'required|digits:10|unique:users,phone']);
    
        $phoneCode = rand(100000, 999999);
    
        DB::table('phone_verifications')->updateOrInsert(
            ['phone' => $request->phone],
            [
                'code' => $phoneCode,
                'expires_at' => now()->addMinutes(60),
                'updated_at' => now(),
            ]
        );
    
        // Formato del teléfono: +54 9 XXX XXXXXXX
        $phone = '+54' . $request->phone;
    
        // Enviar SMS con Twilio (todavia no funca)
        // $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        // $twilio->messages->create($phone, [
        //     'from' => env('TWILIO_PHONE_NUMBER'),
        //     'body' => "Tu código de verificación es: $phoneCode"
        // ]);
    
        return response()->json(['message' => 'Código enviado']);
    }

    public function verifyPhoneToken(Request $request) {
        $request->validate([
            'phone' => 'required|digits:10',
            'code' => 'required|digits:6'
        ]);

        $verification = DB::table('phone_verifications')
            ->where('phone', $request->phone)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            return response()->json(['message' => 'Código inválido o expirado'], 422);
        }

        // Confirmar verificación
        DB::table('phone_verifications')->where('phone', $request->phone)->delete();
        return response()->json(['message' => 'Teléfono verificado correctamente']);
    }

    // Verificar si la contraseña cumple con los requisitos
    public function verifyPassword(Request $request) {
        $request->validate([
            'password' => 'required|min:8',
            'password_confirmation' => 'required'
        ]);

        if ($request->password !== $request->password_confirmation) {
            return response()->json(['message' => 'Las contraseñas no coinciden'], 422);
        }

        return response()->json(['message' => 'Contraseña válida']);
    }

    // Verificar si el DNI es único
    public function verifyIdentity(Request $request) {
        $request->validate(['dni' => 'required|unique:users,dni']);

        return response()->json(['message' => 'Identidad verificada']);
    }
}