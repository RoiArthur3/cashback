<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cashback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CashbackController extends Controller
{
    // Liste des cashbacks
    public function index()
    {
        $cashbacks = Cashback::with('user', 'boutique')->latest()->paginate(20);
        return view('admin.cashbacks.index', compact('cashbacks'));
    }

    // Valider un cashback
    public function valider(Cashback $cashback)
    {
        $cashback->update(['statut' => 'valide', 'type' => 'payout']);
        // Ici, tu peux déclencher le paiement effectif si besoin
        return back()->with('success', 'Cashback validé !');
    }

    // Rembourser un cashback
    public function rembourser(Cashback $cashback)
    {
        $cashback->update(['statut' => 'rembourse', 'type' => 'payout']);
        // Ici, tu peux déclencher le remboursement effectif si besoin
        return back()->with('success', 'Cashback remboursé !');
    }
    
    // Afficher l'accusé de remboursement
    public function accuse(Cashback $cashback)
    {
        $cashback->load(['user', 'boutique']);
        return view('admin.cashbacks.accuse', compact('cashback'));
    }
}
