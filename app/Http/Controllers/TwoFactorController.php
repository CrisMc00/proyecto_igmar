<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google2FA;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function showSetup()
    {
        $user = Auth::user();

        // Generar el secreto solo si no tiene uno
        if (!$user->google2fa_secret) {
            $user->google2fa_secret = Google2FA::generateSecretKey();
            $user->save();
        }

        // Generar la URL para el QR
        $qrCodeUrl = Google2FA::getQRCodeUrl(
            'Sistema Igmar',
            $user->email,
            $user->google2fa_secret
        );

        return view('auth.setup-2fa', ['qr_url' => $qrCodeUrl]);
    }
}
