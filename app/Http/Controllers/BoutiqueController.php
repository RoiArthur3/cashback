<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BoutiqueController extends Controller
{
    // Espace Mon compte > Ma boutique
    public function accountBoutique()
    {
        $boutique = \App\Models\Boutique::where('user_id', auth()->id())->first();
        return view('account.boutique', compact('boutique'));
    }

    // Affiche le formulaire d'édition de la boutique
    public function edit($id)
    {
        $boutique = \App\Models\Boutique::where('id', $id)->first();
        if (!$boutique) {
            abort(404);
        }
        // Vérifier que l'utilisateur est propriétaire ou admin
        if (auth()->id() !== (int) $boutique->user_id && !(auth()->user() && method_exists(auth()->user(), 'hasRole') && auth()->user()->hasRole('admin'))) {
            abort(403);
        }
        return view('boutiques.edit', compact('boutique'));
    }

    // Met à jour la boutique
    public function update(Request $request, $id)
    {
        $boutique = \App\Models\Boutique::where('id', $id)->first();
        if (!$boutique) {
            abort(404);
        }
        if (auth()->id() !== (int) $boutique->user_id && !(auth()->user() && method_exists(auth()->user(), 'hasRole') && auth()->user()->hasRole('admin'))) {
            abort(403);
        }
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'categorie' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'offre' => 'nullable|string|max:255',
            'a_propos' => 'nullable|string',
            'livraison' => 'nullable|string|max:255',
            'zone_livraison' => 'nullable|string|max:255',
            'theme' => 'nullable|string|max:50',
            'layout' => 'nullable|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slide_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'modele' => 'required|string|in:classique,business,pro',
        ]);

        // Gestion du logo (remplacement sécurisé)
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo si présent
            if (!empty($boutique->logo) && \Storage::disk('public')->exists($boutique->logo)) {
                \Storage::disk('public')->delete($boutique->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $logoPath;
        }

        // Gestion des images de slide (remplacement sécurisé)
        if ($request->hasFile('slide_images')) {
            // Supprimer les anciennes images
            if (!empty($boutique->slide_images)) {
                $oldImages = is_array($boutique->slide_images) ? $boutique->slide_images : json_decode($boutique->slide_images, true);
                if (is_array($oldImages)) {
                    foreach ($oldImages as $oldImg) {
                        if (\Storage::disk('public')->exists($oldImg)) {
                            \Storage::disk('public')->delete($oldImg);
                        }
                    }
                }
            }
            $slideImages = [];
            foreach ($request->file('slide_images') as $img) {
                $slideImages[] = $img->store('slides', 'public');
            }
            $validated['slide_images'] = json_encode($slideImages);
        }

        $boutique->update($validated);
        return redirect()->route('boutiques.edit', $boutique->id)->with('success', 'Boutique mise à jour avec succès.');
    }

    // Enregistre une nouvelle boutique
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'categorie' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'offre' => 'nullable|string|max:255',
            'a_propos' => 'nullable|string',
            'livraison' => 'nullable|string|max:255',
            'zone_livraison' => 'nullable|string|max:255',
            'theme' => 'nullable|string|max:50',
            'layout' => 'nullable|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slide_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'modele' => 'required|string|in:classique,business,pro',
        ]);

        // Gestion du logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $logoPath;
        }

        // Gestion des images de slide
        $slideImages = [];
        if ($request->hasFile('slide_images')) {
            foreach ($request->file('slide_images') as $img) {
                $slideImages[] = $img->store('slides', 'public');
            }
            $validated['slide_images'] = json_encode($slideImages);
        }

        $boutique = \App\Models\Boutique::create($validated);
        $lien = $boutique ? route('boutique.show', $boutique->id) : null;
        return response()->view('boutiques.confirmation', [
            'id' => $boutique ? $boutique->id : null,
            'lien' => $lien
        ]);
    }

    // Affiche la liste des boutiques
    public function index()
    {
        $boutiques = \App\Models\Boutique::all();
        return view('boutiques', compact('boutiques'));
    }

    // Affiche la page individuelle d'une boutique
    public function show($id)
    {
        $boutique = \App\Models\Boutique::with(['produits', 'cashbacks', 'avis', 'user'])->findOrFail($id);
        $produitsQuery = $boutique->produits();
        if (request('q')) {
            $produitsQuery = $produitsQuery->where('nom', 'like', '%' . request('q') . '%');
        }
        if (request('prix_min')) {
            $produitsQuery = $produitsQuery->where('prix', '>=', request('prix_min'));
        }
        if (request('prix_max')) {
            $produitsQuery = $produitsQuery->where('prix', '<=', request('prix_max'));
        }
        $produits = $produitsQuery->get();
        $boutique->setRelation('produits', $produits);
        return view('boutiques.show', compact('boutique'));
    }
}
