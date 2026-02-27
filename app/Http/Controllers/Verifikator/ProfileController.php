<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('verifikator.profile', compact('user'));
    }
}