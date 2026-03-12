<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google2FA;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function showSetup() {
        $user = Auth::user();
        if (!$user->google2fa_secret) {
            $user->google2fa_secret = Google2FA::generateSecretKey();
            $user->save();
        }
        $qr_url = Google2FA::getQRCodeUrl('Sistema Igmar', $user->email, $user->google2fa_secret);
        return view('auth.setup-2fa', compact('qr_url'));
    }
}
