<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;

use App\Http\Controllers\LandingController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\LaporanController;
use App\Http\Controllers\User\PelaporanPotensialController;
use App\Http\Controllers\User\PelaporanAktualController;

use App\Http\Controllers\Verifikator\DashboardController;
use App\Http\Controllers\Verifikator\LaporanAktualController;
use App\Http\Controllers\Verifikator\LaporanPotensialController;
use App\Http\Controllers\Verifikator\ProfileController;
use App\Http\Controllers\Verifikator\DokumenAktualController;
use App\Http\Controllers\Verifikator\DokumenPotensialController;

use App\Http\Controllers\Inspektorat\DashboardController as InspektoratDashboardController;
use App\Http\Controllers\Inspektorat\LaporanAktualController as InspektoratLaporanAktualController;
use App\Http\Controllers\Inspektorat\LaporanPotensialController as InspektoratLaporanPotensialController;
use App\Http\Controllers\Inspektorat\ProfileController as InspektoratProfileController;
use App\Http\Controllers\Inspektorat\DokumenAktualController as InspektoratDokumenAktualController;
use App\Http\Controllers\Inspektorat\DokumenPotensialController as InspektoratDokumenPotensialController;

/*root
belum login ke halaman login
sudah login ke halaman dashboard*/
Route::get('/', function () {
    // jika sudah login, langsung ke dashboard berdasarkan role
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'inspektorat') {
            return redirect('/inspektorat/dashboard');
        } elseif ($user->role === 'verifikator') {
            return redirect('/verifikator/dashboard');
        }

        return redirect('/dashboard');
    }

    // belum login: periksa apakah inspektorat atau verifikator pernah login sebelumnya
    // kedua role tersebut dapat melewati landing page setelah kunjungan pertama
    if (!auth()->check() && session('ever_logged_in') && in_array(session('last_role'), ['inspektorat','verifikator'])) {
        return redirect('/login');
    }

    //tampilkan halaman landing pertama kali
    return view('landing.index');
});

// landing page tambahan (dari web.php no 2)
Route::get('/landing', [LandingController::class, 'index'])
    ->name('landing');

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

    // =========================
    // ROUTE USER (PENGGUNA)
    // =========================

    Route::get('/dashboard', function () {

        $user = auth()->user();

        // Jika admin/inspektorat atau verifikator membuka rute umum, arahkan ulang
        if ($user->role === 'inspektorat') {
            return redirect()->route('inspektorat.dashboard');
        }
        if ($user->role === 'verifikator') {
            return redirect()->route('verifikator.dashboard');
        }

        if ($user->role === 'pengguna') {
            return app(UserDashboardController::class)->index();
        }

        abort(403, 'Role tidak dikenali');
    })->name('user.dashboard');

    Route::get('/panduan', function () {
        return view('user.panduan.index');
    })->name('user.panduan');

    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');

    // pelaporan potensial
    Route::get('/pelaporan/potensial/create',
        [PelaporanPotensialController::class, 'create']
    )->name('pelaporan.potensial.create');

    Route::post('/pelaporan/potensial',
        [PelaporanPotensialController::class, 'store']
    )->name('pelaporan.potensial.store');

    Route::get('/pegawai/search-potensial',
        [PelaporanPotensialController::class, 'searchPegawaiPotensial']
    )->name('pegawai.search.potensial');

    // pelaporan aktual
    Route::get('/pelaporan/aktual/create',
        [PelaporanAktualController::class, 'create']
    )->name('pelaporan.aktual.create');

    Route::post('/pelaporan/aktual',
        [PelaporanAktualController::class, 'store']
    )->name('pelaporan.aktual.store');

    Route::get('/pegawai/search-aktual',
        [PelaporanAktualController::class, 'searchPegawaiAktual']
    )->name('pegawai.search.aktual');

    Route::prefix('laporan')->group(function () {
        Route::get('{tipe}/{id}', [LaporanController::class, 'show'])
            ->name('laporan.show');
    });

    // =========================
    // VERIFIKATOR
    // =========================
    Route::middleware('role:verifikator')
        ->prefix('verifikator')
        ->name('verifikator.')
        ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/api/dashboard/chart-data', [DashboardController::class, 'getChartData'])
            ->name('dashboard.chart.data');

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

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

        Route::get('/dokumen-aktual/{id}/download', [DokumenAktualController::class, 'download'])
            ->name('dokumen-aktual.download');
        Route::get('/dokumen-aktual/{id}/view', [DokumenAktualController::class, 'view'])
            ->name('dokumen-aktual.view');

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

        Route::get('/dokumen-potensial/{id}/download', [DokumenPotensialController::class, 'download'])
            ->name('dokumen-potensial.download');
        Route::get('/dokumen-potensial/{id}/view', [DokumenPotensialController::class, 'view'])
            ->name('dokumen-potensial.view');
    });

    // =========================
    // INSPEKTORAT
    // =========================
    Route::middleware('role:inspektorat')->prefix('inspektorat')->name('inspektorat.')->group(function () {

        Route::get('/dashboard', [InspektoratDashboardController::class, 'index'])->name('dashboard');
        Route::get('/api/dashboard/chart-data', [InspektoratDashboardController::class, 'getChartData'])
            ->name('dashboard.chart.data');

        Route::get('/profile', [InspektoratProfileController::class, 'index'])->name('profile.index');

        Route::get('/konflik-aktual/export', [InspektoratLaporanAktualController::class, 'export'])
            ->name('konflik-aktual.export');
        Route::get('/konflik-potensial/export', [InspektoratLaporanPotensialController::class, 'export'])
            ->name('konflik-potensial.export');

        Route::get('/konflik-aktual', [InspektoratLaporanAktualController::class, 'index'])
            ->name('konflik-aktual.index');
        Route::get('/konflik-aktual/{id}', [InspektoratLaporanAktualController::class, 'show'])
            ->name('konflik-aktual.show');

        Route::put('/konflik-aktual/{id}/verifikasi', [InspektoratLaporanAktualController::class, 'updateVerifikasi'])
            ->name('konflik-aktual.verifikasi.update');
        Route::put('/konflik-aktual/{id}/komentar', [InspektoratLaporanAktualController::class, 'updateKomentar'])
            ->name('konflik-aktual.komentar.update');
        Route::put('/konflik-aktual/{id}/rekomendasi', [InspektoratLaporanAktualController::class, 'updateRekomendasi'])
            ->name('konflik-aktual.rekomendasi.update');

        Route::delete('/konflik-aktual/{id}', [InspektoratLaporanAktualController::class, 'destroy'])
            ->name('konflik-aktual.destroy');

        Route::get('/dokumen-aktual/{id}/download', [InspektoratDokumenAktualController::class, 'download'])
            ->name('dokumen-aktual.download');
        Route::get('/dokumen-aktual/{id}/view', [InspektoratDokumenAktualController::class, 'view'])
            ->name('dokumen-aktual.view');

        Route::get('/konflik-potensial', [InspektoratLaporanPotensialController::class, 'index'])
            ->name('konflik-potensial.index');
        Route::get('/konflik-potensial/{id}', [InspektoratLaporanPotensialController::class, 'show'])
            ->name('konflik-potensial.show');

        Route::put('/konflik-potensial/{id}/verifikasi', [InspektoratLaporanPotensialController::class, 'updateVerifikasi'])
            ->name('konflik-potensial.verifikasi.update');
        Route::put('/konflik-potensial/{id}/komentar', [InspektoratLaporanPotensialController::class, 'updateKomentar'])
            ->name('konflik-potensial.komentar.update');
        Route::put('/konflik-potensial/{id}/rekomendasi', [InspektoratLaporanPotensialController::class, 'updateRekomendasi'])
            ->name('konflik-potensial.rekomendasi.update');

        Route::delete('/konflik-potensial/{id}', [InspektoratLaporanPotensialController::class, 'destroy'])
            ->name('konflik-potensial.destroy');

        Route::get('/dokumen-potensial/{id}/download', [InspektoratDokumenPotensialController::class, 'download'])
            ->name('dokumen-potensial.download');
        Route::get('/dokumen-potensial/{id}/view', [InspektoratDokumenPotensialController::class, 'view'])
            ->name('dokumen-potensial.view');
    });

});