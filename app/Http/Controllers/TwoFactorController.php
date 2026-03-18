<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google2FA;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function showSetup() {
        $user = \App\Models\User::find(session('2fa_user_id'));
        
        if (!$user->google2fa_secret) {
            $secret = Google2FA::generateSecretKey();
            session(['temp_2fa_secret' => $secret]); // Guardar temporalmente
        } else {
            $secret = $user->google2fa_secret;
        }

        $qr_url = Google2FA::getQRCodeUrl('Sistema Igmar', $user->email, $secret);
        return view('auth.setup-2fa', compact('qr_url'));
    }
}
