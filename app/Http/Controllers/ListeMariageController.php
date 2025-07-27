<?php

namespace App\Http\Controllers;

use App\Models\ListeMariage;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ListeMariageController extends Controller
{
    /**
     * Afficher la liste des listes de mariage de l'utilisateur
     */
    public function index()
    {
        $listes = Auth::user()->listesMariage()->latest()->paginate(10);
        return view('liste-mariage.index', compact('listes'));
    }

    /**
     * Afficher le formulaire de création d'une nouvelle liste
     */
    public function create()
    {
        return view('liste-mariage.create');
    }

    /**
     * Enregistrer une nouvelle liste de mariage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_mariage' => 'required|date|after:today',
            'image_couverture' => 'nullable|image|max:2048',
            'adresse_livraison' => 'required|string|max:500',
            'telephone_contact' => 'required|string|max:20',
            'email_contact' => 'required|email|max:255',
            'theme' => 'required|string|in:classique,moderne,romantique,naturel',
            'couleur_principale' => 'required|string|size:7',
            'couleur_secondaire' => 'required|string|size:7',
            'est_publique' => 'boolean',
            'mot_de_passe' => 'nullable|string|min:4',
        ]);

        // Générer une URL personnalisée unique
        $urlPersonnalisee = Str::slug($validated['titre']);
        $suffix = 1;
        while (ListeMariage::where('url_personnalisee', $urlPersonnalisee)->exists()) {
            $urlPersonnalisee = Str::slug($validated['titre']) . '-' . $suffix++;
        }

        // Gérer l'upload de l'image de couverture
        if ($request->hasFile('image_couverture')) {
            $path = $request->file('image_couverture')->store('liste-mariage/couverture', 'public');
            $validated['image_couverture'] = $path;
        }

        // Créer la liste
        $liste = Auth::user()->listesMariage()->create([
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'date_mariage' => $validated['date_mariage'],
            'image_couverture' => $validated['image_couverture'] ?? null,
            'url_personnalisee' => $urlPersonnalisee,
            'adresse_livraison' => $validated['adresse_livraison'],
            'telephone_contact' => $validated['telephone_contact'],
            'email_contact' => $validated['email_contact'],
            'theme' => $validated['theme'],
            'couleur_principale' => $validated['couleur_principale'],
            'couleur_secondaire' => $validated['couleur_secondaire'],
            'est_publique' => $validated['est_publique'] ?? true,
            'mot_de_passe' => $validated['mot_de_passe'] ? bcrypt($validated['mot_de_passe']) : null,
            'statut' => 'active',
        ]);

        return redirect()->route('liste-mariage.show', $liste->id)
            ->with('success', 'Votre liste de mariage a été créée avec succès !');
    }

    /**
     * Afficher une liste de mariage publique
     */
    public function showPublic($url)
    {
        $liste = ListeMariage::where('url_personnalisee', $url)
            ->where('est_publique', true)
            ->where('statut', 'active')
            ->firstOrFail();

        // Vérifier le mot de passe si nécessaire
        if ($liste->mot_de_passe && !session()->has('liste_mariage_'.$liste->id)) {
            return view('liste-mariage.password', compact('liste'));
        }

        $produits = $liste->produits()->paginate(12);
        
        return view('liste-mariage.show-public', compact('liste', 'produits'));
    }

    /**
     * Vérifier le mot de passe d'une liste protégée
     */
    public function checkPassword(Request $request, $id)
    {
        $liste = ListeMariage::findOrFail($id);
        
        if (password_verify($request->password, $liste->mot_de_passe)) {
            session(['liste_mariage_'.$liste->id => true]);
            return redirect()->route('liste-mariage.public.show', $liste->url_personnalisee);
        }
        
        return back()->with('error', 'Mot de passe incorrect.');
    }

    /**
     * Afficher une liste de mariage (vue propriétaire)
     */
    public function show($id)
    {
        $liste = Auth::user()->listesMariage()->findOrFail($id);
        $produits = $liste->produits()->paginate(12);
        
        return view('liste-mariage.show', compact('liste', 'produits'));
    }

    /**
     * Afficher le formulaire d'édition d'une liste
     */
    public function edit($id)
    {
        $liste = Auth::user()->listesMariage()->findOrFail($id);
        return view('liste-mariage.edit', compact('liste'));
    }

    /**
     * Mettre à jour une liste de mariage
     */
    public function update(Request $request, $id)
    {
        $liste = Auth::user()->listesMariage()->findOrFail($id);
        
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_mariage' => 'required|date|after:today',
            'image_couverture' => 'nullable|image|max:2048',
            'adresse_livraison' => 'required|string|max:500',
            'telephone_contact' => 'required|string|max:20',
            'email_contact' => 'required|email|max:255',
            'theme' => 'required|string|in:classique,moderne,romantique,naturel',
            'couleur_principale' => 'required|string|size:7',
            'couleur_secondaire' => 'required|string|size:7',
            'est_publique' => 'boolean',
            'mot_de_passe' => 'nullable|string|min:4',
        ]);

        // Mettre à jour l'image de couverture si une nouvelle est fournie
        if ($request->hasFile('image_couverture')) {
            // Supprimer l'ancienne image si elle existe
            if ($liste->image_couverture) {
                Storage::disk('public')->delete($liste->image_couverture);
            }
            $path = $request->file('image_couverture')->store('liste-mariage/couverture', 'public');
            $validated['image_couverture'] = $path;
        }

        // Mettre à jour le mot de passe si fourni
        if (isset($validated['mot_de_passe'])) {
            $validated['mot_de_passe'] = bcrypt($validated['mot_de_passe']);
        } else {
            unset($validated['mot_de_passe']);
        }

        $liste->update($validated);

        return redirect()->route('liste-mariage.show', $liste->id)
            ->with('success', 'Votre liste de mariage a été mise à jour avec succès !');
    }

    /**
     * Supprimer une liste de mariage
     */
    public function destroy($id)
    {
        $liste = Auth::user()->listesMariage()->findOrFail($id);
        
        // Supprimer l'image de couverture si elle existe
        if ($liste->image_couverture) {
            Storage::disk('public')->delete($liste->image_couverture);
        }
        
        $liste->delete();
        
        return redirect()->route('liste-mariage.index')
            ->with('success', 'Votre liste de mariage a été supprimée avec succès.');
    }
    
    /**
     * Ajouter un produit à la liste de mariage (AJAX)
     */
    public function ajouterProduit(Request $request, $listeId)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'message' => 'nullable|string|max:500',
        ]);
        
        $liste = Auth::user()->listesMariage()->findOrFail($listeId);
        $produit = Produit::findOrFail($request->produit_id);
        
        // Vérifier si le produit n'est pas déjà dans la liste
        if ($liste->produits()->where('produit_id', $produit->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Ce produit est déjà dans votre liste.'
            ]);
        }
        
        // Ajouter le produit à la liste
        $liste->produits()->attach($produit->id, [
            'quantite_demandee' => $request->quantite,
            'message' => $request->message,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Le produit a été ajouté à votre liste de mariage.',
            'produit' => $produit->only('id', 'nom', 'prix', 'image')
        ]);
    }
    
    /**
     * Supprimer un produit de la liste de mariage (AJAX)
     */
    public function supprimerProduit(Request $request, $listeId, $produitId)
    {
        $liste = Auth::user()->listesMariage()->findOrFail($listeId);
        $liste->produits()->detach($produitId);
        
        return response()->json([
            'success' => true,
            'message' => 'Le produit a été retiré de votre liste de mariage.'
        ]);
    }
}
