<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\OtpController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Ruta para mostrar el formulario de los 6 números
Route::get('/verify-otp', [OtpController::class, 'show'])->name('otp.verify');

// Ruta para procesar el código enviado
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.post');

// Ruta para la configuración inicial (QR)
Route::get('/setup-2fa', [TwoFactorController::class, 'showSetup'])->name('2fa.setup');

require __DIR__.'/auth.php';
