<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MoncompteController extends Controller
{
    public function moncompte()
    {
        return view('admin.profil.mycompte');
    }

    public function updatepassword(Request $request)
    {
        $user = Auth::user();

        // Validate the current password
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        // Validate the new password and confirm it
        $this->validate($request, [
            'password' => 'required|string|min:3|confirmed',
        ], [
            'password.required' => 'Le nouveau mot de passe est requis.',
            'password.min' => 'Le nouveau mot de passe doit comporter au moins :min caractères..',
            'password.confirmed' => 'La confirmation du nouveau mot de passe ne correspond pas.',
        ]);

        // Update the username if provided
        if ($request->filled('username')) {
            $user->username = $request->input('username');
        }

        // Update the password if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->back()->with('success', 'Mot de passe mis à jour avec succès.');
    }

    public function updateprofile(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $boutiqueName = $user->magasin->nommagasin ?? null;

        $boutiqueFolder = Str::slug($boutiqueName, '_');


        if ($request->hasFile('file')) {
            $media = $request->file('file');
            $name = $media->hashName();
            $path = $media->storeAs($boutiqueFolder . '/profile', $name, 'profile');

            // Supprimer l'ancienne image de profil si elle existe
            if ($user->image) {
                Storage::disk('profile')->delete($user->image);
            }

            // Mettre à jour les informations du fichier
            $user->image = $boutiqueFolder . '/profile/' . $name;
        }

        // Mettre à jour les autres informations de l'utilisateur
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->contact = $request->contact;

        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

}
