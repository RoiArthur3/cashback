<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Récupère les commandes de l'utilisateur connecté
        $orders = auth()->user()->orders()->latest()->get();
        return view('account.orders.index', compact('orders'));
    }

    /**
     * Supprime le dernier compte utilisateur créé.
     */
    public function deleteLastUser()
    {
        $lastUser = \App\Models\User::orderBy('created_at', 'desc')->first();
        if ($lastUser) {
            $lastUser->delete();
            return response()->json(['message' => 'Dernier compte supprimé avec succès.']);
        }
        return response()->json(['message' => 'Aucun compte à supprimer.']);
    }
}
