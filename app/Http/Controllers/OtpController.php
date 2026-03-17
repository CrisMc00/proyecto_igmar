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
        $valid = Google2FA::verifyKey($user->google2fa_secret, $request->code);
        if ($valid) {
            Auth::login($user);
            session()->forget('2fa_user_id');
            session(['otp_verified' => true]);
            return redirect()->intended('/dashboard');
        }
        return back()->withErrors(['code' => 'Código incorrecto.']);
    }
}
