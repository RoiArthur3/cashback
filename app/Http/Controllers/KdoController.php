<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class KdoController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'destinataire_nom' => 'required|string|max:255',
            'destinataire_tel' => 'required|string|max:30',
            'destinataire_adresse' => 'required|string|max:255',
            'message' => 'nullable|string|max:500',
        ]);

        // Ici, on pourrait créer une table kdo_surprises pour stocker la demande
        // Pour la démo, on envoie juste un message de confirmation
        // TODO: enregistrer la demande en base et notifier l'équipe

        return back()->with('success', 'Votre Kdo surprise a bien été enregistré. Nous nous occupons de l\'emballage et de la livraison !');
    }
}
