<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Boutique;
use App\Models\Cashback;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Afficher le tableau de bord administrateur
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $stats = [
            'acheteurs' => User::whereHas('roles', function($query) {
                return $query->where('name', 'acheteur');
            })->count(),
            
            'commercants' => User::whereHas('roles', function($query) {
                return $query->where('name', 'commercant');
            })->count(),
            
            'annonceurs' => User::whereHas('roles', function($query) {
                return $query->where('name', 'annonceur');
            })->count(),
            
            'boutiques' => Boutique::where('active', true)->count(),
            'ventes' => Cashback::sum('montant'),
            'cashback_valides' => Cashback::where('statut', 'valide')->sum('montant'),
            'cashback_attente' => Cashback::where('statut', 'en_attente')->sum('montant'),
            'montant_reverser' => Cashback::where('statut', 'valide')->sum('montant'),
            'litiges' => Cashback::where('statut', 'litige')->count(),
            'retraits' => 0, // À compléter avec la table des retraits
            'ventes_suspectes' => 0, // À compléter avec la logique de détection
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
}
