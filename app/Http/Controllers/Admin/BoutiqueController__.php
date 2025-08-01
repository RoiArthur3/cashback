<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BoutiqueController extends Controller
{
    /**
     * Afficher la liste des boutiques
     */
    public function index()
    {
        $boutiques = Boutique::withCount('produits')->latest()->paginate(15);
        return view('admin.boutiques.index', compact('boutiques'));
    }

    /**
     * Afficher le formulaire de création d'une boutique
     */
    public function create()
    {
        return view('admin.boutiques.create');
    }

    /**
     * Enregistrer une nouvelle boutique
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'categorie' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'quartier' => 'required|string|max:255',
            'taux_cashback' => 'required|numeric|min:0|max:100',
            'livraison_gratuite' => 'boolean',
            'logo' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:5120',
        ]);

        // Gérer le téléchargement du logo
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('boutiques/logos', 'public');
        }

        // Gérer le téléchargement de l'image de couverture
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('boutiques/covers', 'public');
        }

        // Générer un slug unique
        $validated['slug'] = $this->generateUniqueSlug($validated['nom']);
        $validated['statut'] = 'actif';
        $validated['certifie'] = $request->has('certifie');

        Boutique::create($validated);

        return redirect()->route('admin.boutiques.index')
            ->with('success', 'Boutique créée avec succès.');
    }

    /**
     * Afficher une boutique spécifique
     */
    public function show(Boutique $boutique)
    {
        $boutique->loadCount('produits');
        $produits = $boutique->produits()->latest()->paginate(10);

        return view('admin.boutiques.show', compact('boutique', 'produits'));
    }

    /**
     * Afficher le formulaire de modification d'une boutique
     */
    public function edit(Boutique $boutique)
    {
        return view('admin.boutiques.edit', compact('boutique'));
    }

    /**
     * Mettre à jour une boutique
     */
    public function update(Request $request, Boutique $boutique)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'categorie' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'quartier' => 'required|string|max:255',
            'taux_cashback' => 'required|numeric|min:0|max:100',
            'livraison_gratuite' => 'boolean',
            'logo' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:5120',
            'statut' => ['required', Rule::in(['actif', 'inactif', 'en_attente'])],
        ]);

        // Gérer le téléchargement du logo
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo si nécessaire
            if ($boutique->logo) {
                \Storage::disk('public')->delete($boutique->logo);
            }
            $validated['logo'] = $request->file('logo')->store('boutiques/logos', 'public');
        }

        // Gérer le téléchargement de l'image de couverture
        if ($request->hasFile('cover_image')) {
            // Supprimer l'ancienne image de couverture si nécessaire
            if ($boutique->cover_image) {
                \Storage::disk('public')->delete($boutique->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('boutiques/covers', 'public');
        }

        $boutique->update($validated);

        return redirect()->route('admin.boutiques.show', $boutique)
            ->with('success', 'Boutique mise à jour avec succès.');
    }

    /**
     * Supprimer une boutique
     */
    public function destroy(Boutique $boutique)
    {
        // Supprimer les images si elles existent
        if ($boutique->logo) {
            \Storage::disk('public')->delete($boutique->logo);
        }
        if ($boutique->cover_image) {
            \Storage::disk('public')->delete($boutique->cover_image);
        }

        $boutique->delete();

        return redirect()->route('admin.boutiques.index')
            ->with('success', 'Boutique supprimée avec succès.');
    }

    /**
     * Basculer le statut de certification d'une boutique
     */
    public function toggleCertification(Boutique $boutique)
    {
        $boutique->update(['certifie' => !$boutique->certifie]);

        $status = $boutique->certifie ? 'certifiée' : 'décertifiée';
        return back()->with('success', "La boutique a été $status avec succès.");
    }

    /**
     * Générer un slug unique pour une boutique
     */
    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = Boutique::where('slug', 'LIKE', "$slug%")->count();

        return $count ? "$slug-$count" : $slug;
    }
}
