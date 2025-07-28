    // Affiche les nouveautés (boutiques ou produits)
    public function nouveautes()
    {
        // Exemple : dernières boutiques créées
        $boutiques = \App\Models\Boutique::orderBy('created_at', 'desc')->take(20)->get();
        // Vous pouvez aussi ajouter les nouveaux produits si besoin
        return view('boutiques.nouveautes', compact('boutiques'));
    }
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

    // Affiche le formulaire de création de boutique
    public function create()
    {
        return view('boutiques.create');
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

    /**
     * Affiche les détails d'une boutique spécifique.
     *
     * @param  \App\Models\Boutique  $boutique
     * @return \Illuminate\View\View
     */
    public function show(\App\Models\Boutique $boutique)
    {
        // Charger les produits de la boutique avec pagination
        $produits = $boutique->produits()
            ->withCount('achats')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Produits populaires de cette boutique
        $produitsPopulaires = $boutique->produits()
            ->withCount('achats')
            ->orderBy('achats_count', 'desc')
            ->take(4)
            ->get();

        // Boutiques similaires (même catégorie)
        $boutiquesSimilaires = \App\Models\Boutique::where('categorie', $boutique->categorie)
            ->where('id', '!=', $boutique->id)
            ->withCount('produits')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Statistiques de la boutique
        $stats = [
            'produits' => $boutique->produits_count,
            'moyenne_notes' => $boutique->avis()->avg('note') ?? 0,
            'total_avis' => $boutique->avis()->count(),
        ];

        // Campagnes actives de la boutique
        $campagnesActives = $boutique->campagnes()
            ->where('statut', 'active')
            ->whereDate('date_debut', '<=', now())
            ->whereDate('date_fin', '>=', now())
            ->orderBy('date_fin', 'asc')
            ->get();

        return view('boutiques.show', [
            'boutique' => $boutique->load('user'),
            'produits' => $produits,
            'produitsPopulaires' => $produitsPopulaires,
            'boutiquesSimilaires' => $boutiquesSimilaires,
            'stats' => $stats,
            'campagnesActives' => $campagnesActives,
        ]);
    }

    /**
     * Affiche la liste des boutiques
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = \App\Models\Boutique::select('categorie')
            ->whereNotNull('categorie')
            ->distinct()
            ->pluck('categorie')
            ->filter()
            ->values();

        // Boutiques en vedette (avec au moins un produit en vedette)
        $boutiquesVedettes = \App\Models\Boutique::withCount('produits')
            ->whereHas('produits', function($query) {
                $query->where('vedette', true);
            })
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        // Dernières boutiques ajoutées
        $dernieresBoutiques = \App\Models\Boutique::withCount('produits')
            ->orderByDesc('created_at')
            ->take(12)
            ->get();

        // Toutes les boutiques pour la section complète
        $toutesLesBoutiques = \App\Models\Boutique::withCount('produits')
            ->orderByDesc('created_at')
            ->paginate(12);

        // Campagnes actives pour les bannières
        $campagnesActives = \App\Models\Campagne::where('statut', 'active')
            ->whereDate('date_debut', '<=', now())
            ->whereDate('date_fin', '>=', now())
            ->with('annonceur')
            ->orderByDesc('date_debut')
            ->take(6)
            ->get();

        return view('boutiques.index', [
            'categories' => $categories,
            'boutiquesVedettes' => $boutiquesVedettes,
            'dernieresBoutiques' => $dernieresBoutiques,
            'toutesLesBoutiques' => $toutesLesBoutiques,
            'campagnesActives' => $campagnesActives,
        ]);
    }

    /**
     * Affiche les résultats de recherche des boutiques.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $categorie = $request->input('categorie');

        // Construction de la requète de base
        $boutiques = \App\Models\Boutique::withCount('produits')
            ->when($query, function($q) use ($query) {
                return $q->where('nom', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
            })
            ->when($categorie, function($q) use ($categorie) {
                return $q->where('categorie', $categorie);
            })
            ->orderByDesc('created_at')
            ->paginate(12);

        // Récupération des catégories pour le filtre
        $categories = \App\Models\Boutique::select('categorie')
            ->whereNotNull('categorie')
            ->distinct()
            ->pluck('categorie')
            ->filter()
            ->values();

        // Boutiques en vedette pour la sidebar
        $boutiquesVedettes = \App\Models\Boutique::withCount('produits')
            ->whereHas('produits', function($q) {
                $q->where('vedette', true);
            })
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('boutiques.search', [
            'boutiques' => $boutiques,
            'categories' => $categories,
            'boutiquesVedettes' => $boutiquesVedettes,
            'searchQuery' => $query,
            'selectedCategory' => $categorie
        ]);
    }

    // La méthode show avec injection de modèle est conservée ci-dessus
}
