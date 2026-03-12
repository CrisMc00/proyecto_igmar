<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OtpController extends Controller
{
    public function verify(Request $request) {
        $request->validate(['code' => 'required|numeric']);
        $otp = DB::table('otp_codes')
            ->where('email', session('otp_email'))
            ->where('code', $request->code)
            ->where('expires_at', '>', now())->first();

        if ($otp) {
            DB::table('otp_codes')->where('id', $otp->id)->delete();
            session(['otp_verified' => true]);
            return redirect()->intended('/dashboard');
        }
        return back()->withErrors(['code' => 'Código inválido o expirado.']);
    }
}
