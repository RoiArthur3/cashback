<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;

class BoutiqueFrontController extends Controller
{
    /**
     * Affiche la liste des boutiques
     */
    public function index(Request $request)
    {
        // Récupérer toutes les catégories pour le filtre
        $categories = Categorie::orderBy('nom')->get();
        
        // Construire la requête pour les boutiques
        $query = Boutique::query()
            ->with(['produits' => function($query) {
                $query->where('actif', true);
            }])
            ->where('actif', true);
        
        // Filtre par catégorie
        if ($request->has('categorie') && $request->categorie) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->categorie);
            });
        }
        
        // Filtre par recherche
        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Trier les résultats
        switch ($request->input('trier_par')) {
            case 'nouveautes':
                $query->latest();
                break;
            case 'cashback_eleve':
                $query->orderBy('cashback_max', 'desc');
                break;
            case 'notes_elevees':
                $query->orderBy('note_moyenne', 'desc');
                break;
            case 'populaires':
            default:
                $query->orderBy('nb_visites', 'desc');
                break;
        }
        
        // Paginer les résultats
        $boutiques = $query->paginate(12);
        
        // Si c'est une requête AJAX, retourner la vue partielle
        if ($request->ajax()) {
            return view('boutiques.partials.boutiques_list', compact('boutiques'))->render();
        }

        return view('boutiques.new_index', compact('boutiques', 'categories'));
    }

    /**
     * Affiche les détails d'une boutique
     */
    public function show($id, $slug = null)
    {
        $boutique = Boutique::with(['produits' => function($query) {
            $query->where('actif', true);
        }])->findOrFail($id);

        // Redirection si le slug n'est pas correct
        $correctSlug = \Illuminate\Support\Str::slug($boutique->nom);
        if ($slug !== $correctSlug) {
            return redirect()->route('boutiques.show', ['id' => $id, 'slug' => $correctSlug], 301);
        }

        return view('boutiques.show', compact('boutique'));
    }

    /**
     * Affiche les produits d'une catégorie
     */
    public function categorie($categorieSlug)
    {
        $categorie = Categorie::where('slug', $categorieSlug)->firstOrFail();
        
        $produits = Produit::where('categorie_id', $categorie->id)
            ->where('actif', true)
            ->with('boutique')
            ->paginate(16);

        $categories = Categorie::orderBy('nom')->get();

        return view('boutiques.categorie', compact('produits', 'categorie', 'categories'));
    }

    /**
     * Recherche de produits
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $categorieId = $request->input('categorie');
        
        $produits = Produit::where('actif', true)
            ->when($query, function($q) use ($query) {
                return $q->where('nom', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%');
            })
            ->when($categorieId, function($q) use ($categorieId) {
                return $q->where('categorie_id', $categorieId);
            })
            ->with('boutique')
            ->orderBy('created_at', 'desc')
            ->paginate(16)
            ->appends($request->query());

        $categories = Categorie::orderBy('nom')->get();
        $selectedCategorie = $categorieId ? Categorie::find($categorieId) : null;

        return view('boutiques.search', compact('produits', 'query', 'categories', 'selectedCategorie'));
    }
}
