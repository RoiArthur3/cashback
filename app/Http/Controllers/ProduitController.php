<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Categorie;

class ProduitController extends Controller
{
    /**
     * Affiche la liste des produits.
     */
    public function index()
    {
        $produits = Produit::with(['boutique', 'categorie'])
            ->latest()
            ->paginate(12);
            
        $categories = Categorie::all();
        
        return view('produits.index', compact('produits', 'categories'));
    }

    /**
     * Affiche la fiche d'un produit.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\View\View
     */
    public function show(Produit $produit)
    {
        $produit->load(['boutique', 'achats']);
        return view('produits.show', compact('produit'));
    }
}
