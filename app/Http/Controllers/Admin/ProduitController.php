<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Boutique;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProduitController extends Controller
{
    /**
     * Afficher la liste des produits
     */
    public function index()
    {
        $produits = Produit::with(['boutique', 'categorie'])
            ->latest()
            ->paginate(15);
            
        return view('admin.produits.index', compact('produits'));
    }

    /**
     * Afficher le formulaire de création d'un produit
     */
    public function create()
    {
        $boutiques = Boutique::where('statut', 'actif')->get();
        $categories = Categorie::where('est_actif', true)->get();
        
        return view('admin.produits.create', compact('boutiques', 'categories'));
    }

    /**
     * Enregistrer un nouveau produit
     */
    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);
        
        // Gérer l'image du produit
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('produits', 'public');
        }
        
        // Générer un slug unique
        $validated['slug'] = $this->generateUniqueSlug($validated['nom']);
        $validated['statut'] = 'actif';
        $validated['en_promotion'] = $request->has('en_promotion');
        
        if ($validated['en_promotion']) {
            $validated['prix_promotionnel'] = $validated['prix'] - ($validated['prix'] * $validated['promotion'] / 100);
        }
        
        Produit::create($validated);

        return redirect()->route('admin.produits.index')
            ->with('success', 'Produit créé avec succès.');
    }

    /**
     * Afficher un produit spécifique
     */
    public function show(Produit $produit)
    {
        $produit->load(['boutique', 'categorie']);
        return view('admin.produits.show', compact('produit'));
    }

    /**
     * Afficher le formulaire de modification d'un produit
     */
    public function edit(Produit $produit)
    {
        $boutiques = Boutique::where('statut', 'actif')->get();
        $categories = Categorie::where('est_actif', true)->get();
        
        return view('admin.produits.edit', compact('produit', 'boutiques', 'categories'));
    }

    /**
     * Mettre à jour un produit
     */
    public function update(Request $request, Produit $produit)
    {
        $validated = $this->validateProduct($request, $produit->id);
        
        // Gérer l'image du produit
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($produit->image) {
                \Storage::disk('public')->delete($produit->image);
            }
            $validated['image'] = $request->file('image')->store('produits', 'public');
        }
        
        $validated['en_promotion'] = $request->has('en_promotion');
        
        if ($validated['en_promotion']) {
            $validated['prix_promotionnel'] = $validated['prix'] - ($validated['prix'] * $validated['promotion'] / 100);
        } else {
            $validated['prix_promotionnel'] = null;
            $validated['date_debut_promotion'] = null;
            $validated['date_fin_promotion'] = null;
        }
        
        $produit->update($validated);

        return redirect()->route('admin.produits.show', $produit)
            ->with('success', 'Produit mis à jour avec succès.');
    }

    /**
     * Supprimer un produit
     */
    public function destroy(Produit $produit)
    {
        // Supprimer l'image si elle existe
        if ($produit->image) {
            \Storage::disk('public')->delete($produit->image);
        }
        
        $produit->delete();

        return redirect()->route('admin.produits.index')
            ->with('success', 'Produit supprimé avec succès.');
    }
    
    /**
     * Valider les données du produit
     */
    private function validateProduct(Request $request, $productId = null)
    {
        $rules = [
            'boutique_id' => 'required|exists:boutiques,id',
            'categorie_id' => 'required|exists:categories,id',
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'prix_compare' => 'nullable|numeric|min:0|gt:prix',
            'stock' => 'required|integer|min:0',
            'promotion' => 'nullable|integer|min:0|max:100',
            'nouveau' => 'boolean',
            'meilleure_vente' => 'boolean',
            'note_moyenne' => 'nullable|numeric|min:0|max:5',
            'image' => 'nullable|image|max:5120',
            'statut' => ['required', Rule::in(['actif', 'inactif', 'rupture'])],
        ];
        
        if ($request->has('en_promotion')) {
            $rules['date_debut_promotion'] = 'nullable|date';
            $rules['date_fin_promotion'] = 'nullable|date|after_or_equal:date_debut_promotion';
        }
        
        return $request->validate($rules);
    }
    
    /**
     * Générer un slug unique pour un produit
     */
    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = Produit::where('slug', 'LIKE', "$slug%")->count();
        
        return $count ? "$slug-$count" : $slug;
    }
}
