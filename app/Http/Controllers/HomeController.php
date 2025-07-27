<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Boutique;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware d'authentification retiré pour permettre l'accès public
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /**
     * Affiche la page d'accueil publique avec les produits populaires et les boutiques tendances.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupérer les produits les plus populaires (par nombre de vues)
        $produitsPopulaires = Produit::with(['boutique', 'categorie'])
            ->orderBy('vues', 'desc')
            ->orderBy('created_at', 'desc') // En cas d'égalité de vues
            ->take(8)
            ->get();
            
        // Récupérer les boutiques avec le plus de produits
        $boutiquesTendances = Boutique::withCount('produits')
            ->orderBy('produits_count', 'desc')
            ->take(6)
            ->get();
            
        return view('welcome', [
            'produitsPopulaires' => $produitsPopulaires,
            'boutiquesTendances' => $boutiquesTendances,
            'pageTitle' => 'Accueil - Cashback Market'
        ]);
    }

    /**
     * Recherche de produits et boutiques
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return redirect()->back()->with('error', 'Veuillez entrer un terme de recherche.');
        }

        // Recherche des produits
        $produits = Produit::where('nom', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->with('boutique')
            ->paginate(12);

        // Recherche des boutiques
        $boutiques = Boutique::where('nom', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->paginate(12);

        return view('search.results', [
            'query' => $query,
            'produits' => $produits,
            'boutiques' => $boutiques
        ]);
    }
}
