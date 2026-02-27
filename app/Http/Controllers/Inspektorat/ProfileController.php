<?php

namespace App\Http\Controllers\Inspektorat;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('inspektorat.profile', compact('user'));
    }
}