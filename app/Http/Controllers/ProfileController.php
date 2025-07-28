<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Affiche le profil de l'utilisateur connecté.
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }
}
