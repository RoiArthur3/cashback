<?php

namespace App\Http\Controllers;

use App\Models\Taille;
use App\Models\Produit;
use App\Models\Boutique;
use App\Models\Categorie;
use App\Models\BlackFriday;
use App\Models\TypeBoutique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function listesboutiques(Request $request)
    {
        $typeBoutiqueId = $request->input('type_boutique');
        $typeboutiques = TypeBoutique::all();

        $boutiques = Boutique::with('typeboutique')
            ->where('active', 1)
            ->when($typeBoutiqueId, function ($query, $typeBoutiqueId) {
                return $query->where('type_boutique_id', $typeBoutiqueId);
            })
            ->get();

        return view('frontend.boutique.lesboutiques', compact('boutiques', 'typeboutiques', 'typeBoutiqueId'));
    }

    public function laboutique($boutiqueSlug)
    {
        $boutique = Boutique::where('slug', $boutiqueSlug)->first();

        if (!$boutique) {
            $boutique = Boutique::find($boutiqueSlug);
        }

        if (!$boutique) {
            return redirect()->route('home')->with('error', 'Boutique non trouvée');
        }

        $id = $boutique->id;

        $dixproduits = Produit::where('boutique_id', $id)
            ->where('en_vedetteimg', true)
            ->where('statut','Active')
            ->take(10)
            ->get();

        $dixproduitsderniers = Produit::where('boutique_id', $id)
            ->where('statut','Active')
            ->latest()
            ->take(10)
            ->get();

        $produitvedettes = Produit::where('boutique_id', $id)
            ->where('en_vedette', true)
            ->where('statut','Active')
            ->take(8)->get();

        /* $vedettes = VedetteMagasin::where('boutique_id', $id)
        ->get(); */

        /* $imageclients = ImageClient::where('boutique_id', $id)
        ->get(); */

        $categories = Categorie::where('boutique_id', $id)->get();

        $blackFriday = BlackFriday::where('boutique_id', $id)->where('is_active', true)->first();

        return view('frontend.boutique.laboutique', compact('boutique', 'dixproduits', 'categories', 'dixproduitsderniers', 'produitvedettes','blackFriday'));
    }

    public function leproduit($boutiqueSlug, $slug)
    {
        $boutique = Boutique::where('slug', $boutiqueSlug)->first();

        if (!$boutique) {
            return redirect()->route('home')->with('error', 'Boutique non trouvée');
        }

        $produit = Produit::where('slug', $slug)->where('boutique_id', $boutique->id)->first();

        if (!$produit) {
            return redirect()->route('home')->with('error', 'Produit non trouvé dans cette boutique');
        }

        $taille_ids = $produit->taille_id ? (is_string($produit->taille_id) ? json_decode($produit->taille_id, true) : $produit->taille_id) : [];
        $pointure_ids = $produit->pointure_id ? (is_string($produit->pointure_id) ? json_decode($produit->pointure_id, true) : $produit->pointure_id) : [];

        $tailles = !empty($taille_ids) ? Taille::whereIn('id', $taille_ids)->get() : collect();
        /* $pointures = !empty($pointure_ids) ? Pointure::whereIn('id', $pointure_ids)->get() : collect(); */

        // Récupérer tous les produits de la même catégorie
        $produitsCategories = Produit::where('categorie_id', $produit->categorie_id)
        ->where('boutique_id', $boutique->id)
        ->where('id', '!=', $produit->id)
        ->take(4)
        ->get();


        return view('frontend.boutique.produits.leproduit', compact('produit', 'boutique','produitsCategories','tailles'));
    }

    public function lescategories($boutiqueSlug)
    {
        // Récupérer la boutique avec le slug
        $boutique = Boutique::where('slug', $boutiqueSlug)->first();

        // Vérifie si la boutique existe
        if (!$boutique) {
            return redirect()->route('home')->with('error', 'Boutique non trouvée');
        }

        // Récupérer toutes les catégories de la boutique
        $categories = Categorie::where('boutique_id', $boutique->id)->get();

        // Vérifie si une catégorie a été sélectionnée via l'URL
        $categorieSlug = request()->route('slug'); // On récupère le slug de la catégorie depuis l'URL
        $categorie = null;
        $produits = collect(); // Initialisation d'une collection vide pour les produits

        // Si un slug de catégorie est fourni dans l'URL, on récupère les produits de cette catégorie
        if ($categorieSlug) {
            $categorie = Categorie::where('slug', $categorieSlug)
                ->where('boutique_id', $boutique->id)
                ->first(); // Trouver la catégorie spécifique

            if ($categorie) {
                // Récupérer les produits de la catégorie spécifique
                $produits = Produit::where('categorie_id', $categorie->id)
                    ->where('boutique_id', $boutique->id)
                    ->get();
            }
        } else {
            // Si aucune catégorie n'est sélectionnée, on récupère tous les produits de la boutique
            $produits = Produit::where('boutique_id', $boutique->id)->latest()->get();
        }

        // Retourner la vue avec les données nécessaires
        return view('frontend.boutique.produits.lesproduitbycategorie', compact('boutique', 'categories', 'categorie', 'produits'));
    }

    public function afficherParCategorie($boutiqueSlug, $slug)
    {
        $boutique = Boutique::where('slug', $boutiqueSlug)->first();

        if (!$boutique) {
            return redirect()->route('home')->with('error', 'Boutique non trouvée');
        }

        $categorie = Categorie::where('slug', $slug)->where('boutique_id', $boutique->id)->first();

        $categories = Categorie::where('boutique_id', $boutique->id)->get();

        $produits = Produit::where('categorie_id', $categorie->id)->where('boutique_id', $boutique->id)->latest()->get();

        return view('frontend.boutique.produits.lesproduitbycategorie', compact('categorie', 'produits', 'boutique','categories'));
    }
}
