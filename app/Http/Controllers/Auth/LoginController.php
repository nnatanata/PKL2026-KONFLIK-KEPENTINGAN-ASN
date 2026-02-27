<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // redirect sesuai role
            $user = Auth::user();

            // simpan riwayat kunjungan untuk role "inspektorat" dan "verifikator"
            // agar mereka tidak melihat landing page lagi setelah pertama kali login
            if (in_array($user->role, ['inspektorat', 'verifikator'])) {
                session([
                    'ever_logged_in' => true,
                    'last_role' => $user->role,
                ]);
            }

            if ($user->role === 'inspektorat') {
                return redirect()->intended('/inspektorat/dashboard');
            } elseif ($user->role === 'verifikator') {
                return redirect()->intended('/verifikator/dashboard');
            }
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}