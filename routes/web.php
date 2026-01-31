<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanAktualController;
use App\Http\Controllers\Admin\LaporanPotensialController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DokumenAktualController;
use App\Http\Controllers\Admin\DokumenPotensialController;

/*root
belum login ke halaman login
sudah login ke halaman dashboard*/
Route::get('/', function () {
    return auth()->check()
        ? redirect('/dashboard')
        : redirect('/login');
});

//force logout sementara
Route::get('/force-logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/login');
});

//guest (belum login)
Route::middleware('guest')->group(function () {

    //login
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login']);

    //forgot password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])
        ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
        ->name('password.email');

    //reset password  link dari email
    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');

    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect('/login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    })->name('password.update');
});

//auth (sudah login)
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/dashboard/chart-data', [DashboardController::class, 'getChartData'])
        ->name('dashboard.chart.data');

    //profil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    //konflik Aktual
    Route::get('/konflik-aktual', [LaporanAktualController::class, 'index'])
        ->name('konflik-aktual.index');
    Route::get('/konflik-aktual/{id}', [LaporanAktualController::class, 'show'])
        ->name('konflik-aktual.show');
    
    Route::put('/konflik-aktual/{id}/verifikasi', [LaporanAktualController::class, 'updateVerifikasi'])
        ->name('konflik-aktual.verifikasi.update');
    Route::put('/konflik-aktual/{id}/komentar', [LaporanAktualController::class, 'updateKomentar'])
        ->name('konflik-aktual.komentar.update');
    
    Route::delete('/konflik-aktual/{id}', [LaporanAktualController::class, 'destroy'])
        ->name('konflik-aktual.destroy');
    
    //dokumen aktual
    Route::get('/dokumen-aktual/{id}/download', [DokumenAktualController::class, 'download'])
        ->name('dokumen-aktual.download');
    Route::get('/dokumen-aktual/{id}/view', [DokumenAktualController::class, 'view'])
        ->name('dokumen-aktual.view');

    //konflik Potensial
    Route::get('/konflik-potensial', [LaporanPotensialController::class, 'index'])
        ->name('konflik-potensial.index');
    Route::get('/konflik-potensial/{id}', [LaporanPotensialController::class, 'show'])
        ->name('konflik-potensial.show');
    
    Route::put('/konflik-potensial/{id}/verifikasi', [LaporanPotensialController::class, 'updateVerifikasi'])
        ->name('konflik-potensial.verifikasi.update');
    Route::put('/konflik-potensial/{id}/komentar', [LaporanPotensialController::class, 'updateKomentar'])
        ->name('konflik-potensial.komentar.update');
    
    Route::delete('/konflik-potensial/{id}', [LaporanPotensialController::class, 'destroy'])
        ->name('konflik-potensial.destroy');
    
    //dokumen potensial
    Route::get('/dokumen-potensial/{id}/download', [DokumenPotensialController::class, 'download'])
        ->name('dokumen-potensial.download');
    Route::get('/dokumen-potensial/{id}/view', [DokumenPotensialController::class, 'view'])
        ->name('dokumen-potensial.view');
        
});