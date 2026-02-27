<?php

namespace App\Http\Controllers;

class LandingController extends Controller
{
    public function index()
    {
        // jika sudah login, langsung alihkan ke dashboard sesuai role
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->role === 'inspektorat') {
                return redirect('/inspektorat/dashboard');
            }
            if ($user->role === 'verifikator') {
                return redirect('/verifikator/dashboard');
            }
            return redirect('/dashboard');
        }

        return view('landing.index');
    }
}