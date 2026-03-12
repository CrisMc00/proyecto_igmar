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
        $user = Auth::user();
        $valid = Google2FA::verifyKey($user->google2fa_secret, $request->code);
        if ($valid) {
            session(['otp_verified' => true]);
            return redirect()->intended('/dashboard');
        }
        return back()->withErrors(['code' => 'Código incorrecto.']);
    }
}
