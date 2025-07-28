<?php

namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\Cashback;
use Illuminate\Support\Facades\Auth;

class CashbackController extends Controller
{
    // Liste des cashbacks remboursés pour la boutique connectée
    public function index()
    {
        $boutique = Auth::user()->boutique;
        $cashbacks = Cashback::with('user')
            ->where('boutique_id', $boutique->id)
            ->where('statut', 'rembourse')
            ->orderByDesc('updated_at')
            ->get();
        return view('boutique.cashbacks.index', compact('cashbacks'));
    }

    // Afficher l'accusé de remboursement
    public function accuse(Cashback $cashback)
    {
        $this->authorize('view', $cashback); // Optionnel: policy
        $cashback->load('user');
        return view('boutique.cashbacks.accuse', compact('cashback'));
    }
}
