<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\LaporanController;
use App\Http\Controllers\User\PelaporanPotensialController;
use App\Http\Controllers\User\PelaporanAktualController;

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

    // logout
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    // dashboard
    Route::get('/dashboard', function () {

        $user = auth()->user();

        if (in_array($user->role, ['inspektorat', 'verifikator'])) {
            return view('admin.dashboard');
        }

        if ($user->role === 'pengguna') {
            return app(UserDashboardController::class)->index();
        }

        abort(403, 'Role tidak dikenali');
    })->name('user.dashboard');

    Route::get(
        '/laporan',
        [LaporanController::class, 'index']
    )->name('laporan.index');

    // pelaporan potensial
    Route::get(
        '/pelaporan/potensial/create',
        [PelaporanPotensialController::class, 'create']
    )->name('pelaporan.potensial.create');

    Route::post(
        '/pelaporan/potensial',
        [PelaporanPotensialController::class, 'store']
    )->name('pelaporan.potensial.store');

    Route::get(
        '/pegawai/search',
        [PelaporanPotensialController::class, 'searchPegawaiPotensial']
    )->name('pegawai.search');

    // pelaporan aktual
    Route::get(
        '/pelaporan/aktual/create',
        [PelaporanAktualController::class, 'create']
    )->name('pelaporan.aktual.create');

    Route::post(
        '/pelaporan/aktual',
        [PelaporanAktualController::class, 'store']
    )->name('pelaporan.aktual.store');

    Route::get(
        '/pegawai/search',
        [PelaporanAktualController::class, 'searchPegawaiAktual']
    )->name('pegawai.search');
});


