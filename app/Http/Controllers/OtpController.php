<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Google2FA;

class OtpController extends Controller
{
    public function show() { return view('auth.verify-otp'); }

    public function verify(Request $request) {
        $request->validate(['code' => 'required|numeric']);
        $user = \App\Models\User::find(session('2fa_user_id'));
        
        $secret = $user->google2fa_secret ?: session('temp_2fa_secret');

        $valid = Google2FA::verifyKey($secret, $request->code);

        if ($valid) {
            // Si el usuario no tenía secreto (es nuevo), se lo guardamos ahora sí
            if (!$user->google2fa_secret) {
                $user->google2fa_secret = $secret;
                $user->save();
            }

            Auth::login($user);
            session()->forget(['2fa_user_id', 'temp_2fa_secret']); // Limpiamos
            return redirect()->intended('/dashboard');
        }
        return back()->withErrors(['code' => 'Código incorrecto.']);
    }
}
