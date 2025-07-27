<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcheteurController extends Controller
{
    // Affiche le profil de l'acheteur
    public function profil()
    {
        $user = Auth::user();
        return view('acheteur.profil', compact('user'));
    }

    // Met à jour les informations du profil
    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . ($user ? $user->getKey() : ''),
        ]);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }

    // Dashboard principal de l'acheteur
    public function dashboard()
    {
        return view('acheteur.dashboard');
    }
}
