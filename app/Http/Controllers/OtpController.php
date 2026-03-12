<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google2FA;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class OtpController extends Controller
{
    public function show()
    {
        return view('auth.verify-otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric',
        ]);

        $user = Auth::user();

        // Si el usuario no tiene secreto aún, lo mandamos a configurar
        if (!$user->google2fa_secret) {
            return redirect()->route('2fa.setup');
        }

        // Validamos el código usando la librería Google2FA
        $valid = Google2FA::verifyKey($user->google2fa_secret, $request->code);

        if ($valid) {
            // Guardamos en la sesión que el OTP fue superado correctamente
            session(['otp_verified' => true]);

            return redirect()->intended('/dashboard');
        }

        // Si falla, regresamos con error
        return back()->withErrors(['code' => 'El código es incorrecto. Revisa tu aplicación Google Authenticator.']);
    }
}
