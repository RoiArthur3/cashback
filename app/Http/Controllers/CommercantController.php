<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Cashback;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommercantController extends Controller
{
    /**
     * Afficher la page d'accueil du commerçant
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return $this->dashboard();
    }
    
    /**
     * Afficher le tableau de bord du commerçant
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = Auth::user();
        $boutique = Boutique::where('user_id', $user->id)->first();
        
        if (!$boutique) {
            return redirect("/boutiques/{$user->id}/create");
        }
        
        // Récupérer les statistiques de la boutique
        $stats = [
            'ventes_total' => Cashback::where('boutique_id', $boutique->id)
                ->where('statut', 'valide')
                ->sum('montant'),
                
            'ventes_mois' => Cashback::where('boutique_id', $boutique->id)
                ->where('statut', 'valide')
                ->whereMonth('created_at', now()->month)
                ->sum('montant'),
                
            'commandes_attente' => Commande::where('boutique_id', $boutique->id)
                ->where('statut', 'en_attente')
                ->count(),
                
            'cashback_attente' => Cashback::where('boutique_id', $boutique->id)
                ->where('statut', 'en_attente')
                ->sum('montant'),
        ];
        
        return view('commercant.dashboard', compact('boutique', 'stats'));
    }
    
    // Ajoutez ici les autres actions spécifiques au commerçant
}
