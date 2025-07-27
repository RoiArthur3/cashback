<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Produit;
use App\Models\Achat;
use App\Models\Cashback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendeurController extends Controller
{
    /**
     * Afficher le tableau de bord du vendeur
     */
    public function dashboard()
    {
        $user = Auth::user();
        $boutique = $user->boutique;
        
        // Si le vendeur n'a pas encore de boutique, rediriger vers la création
        if (!$boutique) {
            return redirect()->route('vendeur.boutique.create')
                ->with('info', 'Veuillez d\'abord créer votre boutique pour accéder au tableau de bord.');
        }
        
        // Statistiques de base
        $stats = [
            'produits' => $boutique->produits()->count(),
            'ventes' => $boutique->achats()->count(),
            'chiffre_affaires' => $boutique->achats()->sum('montant'),
            'cashback_total' => $boutique->cashbacks()->sum('montant'),
            'ventes_mois' => $boutique->achats()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'ca_mois' => $boutique->achats()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('montant'),
            'cashback_mois' => $boutique->cashbacks()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('montant'),
        ];
        
        // Dernières commandes
        $commandes = $boutique->achats()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();
            
        // Produits les plus vendus
        $produitsPopulaires = $boutique->produits()
            ->withCount('achats')
            ->orderBy('achats_count', 'desc')
            ->take(5)
            ->get();
            
        // Graphique des ventes des 6 derniers mois
        $ventesParMois = $boutique->achats()
            ->select(
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('COUNT(*) as total_ventes'),
                DB::raw('SUM(montant) as chiffre_affaires')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();
            
        return view('vendeur.dashboard', compact(
            'boutique',
            'stats',
            'commandes',
            'produitsPopulaires',
            'ventesParMois'
        ));
    }
    
    /**
     * Afficher le formulaire de création de boutique
     */
    public function createBoutique()
    {
        if (Auth::user()->boutique) {
            return redirect()->route('vendeur.dashboard');
        }
        
        $categories = \App\Models\Categorie::where('est_actif', true)
            ->orderBy('nom')
            ->get();
            
        return view('vendeur.boutique.create', compact('categories'));
    }
    
    /**
     * Enregistrer une nouvelle boutique
     */
    public function storeBoutique(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:100',
            'code_postal' => 'required|string|max:20',
            'pays' => 'required|string|max:100',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'site_web' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banniere' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'categorie_id' => 'required|exists:categories,id',
            'pourcentage_cashback' => 'required|numeric|min:0|max:100',
            'delai_validation' => 'required|integer|min:1|max:365',
            'conditions' => 'nullable|string|max:1000',
            'horaires' => 'nullable|string|max:500',
            'reseaux_sociaux' => 'nullable|array',
            'reseaux_sociaux.*' => 'nullable|url|max:255',
        ]);
        
        // Gestion des uploads
        if ($request->hasFile('logo')) {
            $validated['logo_url'] = $request->file('logo')->store('boutiques/logos', 'public');
        }
        
        if ($request->hasFile('banniere')) {
            $validated['banniere_url'] = $request->file('banniere')->store('boutiques/bannieres', 'public');
        }
        
        // Création de la boutique
        $boutique = new Boutique($validated);
        $boutique->user_id = Auth::id();
        $boutique->statut = 'en_attente'; // En attente de validation par l'admin
        $boutique->save();
        
        // Mise à jour du rôle de l'utilisateur s'il n'est pas déjà vendeur
        if (Auth::user()->role !== 'vendeur') {
            Auth::user()->update(['role' => 'vendeur']);
        }
        
        return redirect()->route('vendeur.dashboard')
            ->with('success', 'Votre boutique a été créée avec succès. Elle est en attente de validation par nos équipes.');
    }
    
    /**
     * Afficher le formulaire d'édition de la boutique
     */
    public function editBoutique()
    {
        $boutique = Auth::user()->boutique;
        
        if (!$boutique) {
            return redirect()->route('vendeur.boutique.create');
        }
        
        $categories = \App\Models\Categorie::where('est_actif', true)
            ->orderBy('nom')
            ->get();
            
        return view('vendeur.boutique.edit', compact('boutique', 'categories'));
    }
    
    /**
     * Mettre à jour la boutique
     */
    public function updateBoutique(Request $request)
    {
        $boutique = Auth::user()->boutique;
        
        if (!$boutique) {
            return redirect()->route('vendeur.boutique.create');
        }
        
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:100',
            'code_postal' => 'required|string|max:20',
            'pays' => 'required|string|max:100',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'site_web' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banniere' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'categorie_id' => 'required|exists:categories,id',
            'pourcentage_cashback' => 'required|numeric|min:0|max:100',
            'delai_validation' => 'required|integer|min:1|max:365',
            'conditions' => 'nullable|string|max:1000',
            'horaires' => 'nullable|string|max:500',
            'reseaux_sociaux' => 'nullable|array',
            'reseaux_sociaux.*' => 'nullable|url|max:255',
        ]);
        
        // Gestion des uploads
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo s'il existe
            if ($boutique->logo_url) {
                \Storage::disk('public')->delete($boutique->logo_url);
            }
            $validated['logo_url'] = $request->file('logo')->store('boutiques/logos', 'public');
        }
        
        if ($request->hasFile('banniere')) {
            // Supprimer l'ancienne bannière si elle existe
            if ($boutique->banniere_url) {
                \Storage::disk('public')->delete($boutique->banniere_url);
            }
            $validated['banniere_url'] = $request->file('banniere')->store('boutiques/bannieres', 'public');
        }
        
        // Mise à jour de la boutique
        $boutique->update($validated);
        
        return redirect()->route('vendeur.dashboard')
            ->with('success', 'Votre boutique a été mise à jour avec succès.');
    }
    
    /**
     * Afficher la liste des commandes
     */
    public function commandes()
    {
        $boutique = Auth::user()->boutique;
        
        if (!$boutique) {
            return redirect()->route('vendeur.boutique.create');
        }
        
        $commandes = $boutique->achats()
            ->with(['user', 'produit'])
            ->latest()
            ->paginate(15);
            
        return view('vendeur.commandes.index', compact('commandes'));
    }
    
    /**
     * Afficher les détails d'une commande
     */
    public function showCommande($id)
    {
        $commande = Achat::with(['user', 'produit', 'boutique'])
            ->where('boutique_id', Auth::user()->boutique->id)
            ->findOrFail($id);
            
        return view('vendeur.commandes.show', compact('commande'));
    }
    
    /**
     * Mettre à jour le statut d'une commande
     */
    public function updateCommandeStatus(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,en_cours,expediee,livree,annulee,remboursee',
            'commentaire' => 'nullable|string|max:500'
        ]);
        
        $commande = Achat::where('boutique_id', Auth::user()->boutique->id)
            ->findOrFail($id);
            
        $commande->update([
            'statut' => $request->statut,
            'commentaire_vendeur' => $request->commentaire
        ]);
        
        // Si la commande est marquée comme expédiée, on peut créer le cashback
        if ($request->statut === 'expediee' && !$commande->cashback) {
            $cashback = new Cashback([
                'user_id' => $commande->user_id,
                'boutique_id' => $commande->boutique_id,
                'achat_id' => $commande->id,
                'montant' => $commande->montant * ($commande->boutique->pourcentage_cashback / 100),
                'statut' => 'en_attente',
                'date_validation' => now()->addDays($commande->boutique->delai_validation),
            ]);
            
            $cashback->save();
        }
        
        return back()->with('success', 'Statut de la commande mis à jour avec succès');
    }
    
    /**
     * Afficher la liste des produits
     */
    public function produits()
    {
        $boutique = Auth::user()->boutique;
        
        if (!$boutique) {
            return redirect()->route('vendeur.boutique.create');
        }
        
        $produits = $boutique->produits()
            ->with('categorie')
            ->latest()
            ->paginate(15);
            
        return view('vendeur.produits.index', compact('produits'));
    }
    
    /**
     * Afficher le formulaire de création de produit
     */
    public function createProduit()
    {
        $boutique = Auth::user()->boutique;
        
        if (!$boutique) {
            return redirect()->route('vendeur.boutique.create');
        }
        
        $categories = \App\Models\Categorie::where('est_actif', true)
            ->orderBy('nom')
            ->get();
            
        return view('vendeur.produits.create', compact('categories'));
    }
    
    /**
     * Enregistrer un nouveau produit
     */
    public function storeProduit(Request $request)
    {
        $boutique = Auth::user()->boutique;
        
        if (!$boutique) {
            return redirect()->route('vendeur.boutique.create');
        }
        
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'prix_promotion' => 'nullable|numeric|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'quantite' => 'required|integer|min:0',
            'reference' => 'required|string|max:100|unique:produits,reference',
            'marque' => 'nullable|string|max:100',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'caracteristiques' => 'nullable|array',
            'est_en_vedette' => 'boolean',
            'est_disponible' => 'boolean',
        ]);
        
        // Gestion des images
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('produits', 'public');
                $images[] = $path;
            }
            $validated['images'] = $images;
        }
        
        // Création du produit
        $produit = new Produit($validated);
        $produit->boutique_id = $boutique->id;
        $produit->save();
        
        return redirect()->route('vendeur.produits')
            ->with('success', 'Produit créé avec succès');
    }
    
    /**
     * Afficher le formulaire d'édition d'un produit
     */
    public function editProduit($id)
    {
        $produit = Produit::where('boutique_id', Auth::user()->boutique->id)
            ->findOrFail($id);
            
        $categories = \App\Models\Categorie::where('est_actif', true)
            ->orderBy('nom')
            ->get();
            
        return view('vendeur.produits.edit', compact('produit', 'categories'));
    }
    
    /**
     * Mettre à jour un produit
     */
    public function updateProduit(Request $request, $id)
    {
        $produit = Produit::where('boutique_id', Auth::user()->boutique->id)
            ->findOrFail($id);
            
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'prix_promotion' => 'nullable|numeric|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'quantite' => 'required|integer|min:0',
            'reference' => 'required|string|max:100|unique:produits,reference,' . $id,
            'marque' => 'nullable|string|max:100',
            'images' => 'sometimes|array|min:1|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'caracteristiques' => 'nullable|array',
            'est_en_vedette' => 'boolean',
            'est_disponible' => 'boolean',
        ]);
        
        // Gestion des images
        if ($request->hasFile('images')) {
            // Supprimer les anciennes images
            foreach ($produit->images as $image) {
                \Storage::disk('public')->delete($image);
            }
            
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('produits', 'public');
                $images[] = $path;
            }
            $validated['images'] = $images;
        }
        
        // Mise à jour du produit
        $produit->update($validated);
        
        return redirect()->route('vendeur.produits')
            ->with('success', 'Produit mis à jour avec succès');
    }
    
    /**
     * Supprimer un produit
     */
    public function deleteProduit($id)
    {
        $produit = Produit::where('boutique_id', Auth::user()->boutique->id)
            ->findOrFail($id);
            
        // Supprimer les images associées
        foreach ($produit->images as $image) {
            \Storage::disk('public')->delete($image);
        }
        
        $produit->delete();
        
        return back()->with('success', 'Produit supprimé avec succès');
    }
    
    /**
     * Afficher les statistiques de vente
     */
    public function statistiques()
    {
        $boutique = Auth::user()->boutique;
        
        if (!$boutique) {
            return redirect()->route('vendeur.boutique.create');
        }
        
        // Statistiques générales
        $stats = [
            'total_ventes' => $boutique->achats()->count(),
            'chiffre_affaires' => $boutique->achats()->sum('montant'),
            'moyenne_panier' => $boutique->achats()->avg('montant') ?? 0,
            'produits_vendus' => $boutique->achats()->sum('quantite'),
            'taux_conversion' => 0, // À implémenter avec les vues de produits
            'clients_uniques' => $boutique->achats()->distinct('user_id')->count('user_id'),
            'taux_fidelisation' => 0, // À implémenter avec l'historique des commandes
        ];
        
        // Ventes par période
        $ventesParMois = $boutique->achats()
            ->select(
                DB::raw('YEAR(created_at) as annee'),
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('COUNT(*) as total_ventes'),
                DB::raw('SUM(montant) as chiffre_affaires')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('annee', 'mois')
            ->orderBy('annee')
            ->orderBy('mois')
            ->get();
            
        // Produits les plus vendus
        $produitsPopulaires = $boutique->produits()
            ->withCount('achats')
            ->withSum('achats', 'quantite')
            ->orderBy('achats_count', 'desc')
            ->take(5)
            ->get();
            
        // Clients fidèles
        $clientsFideles = $boutique->achats()
            ->select(
                'user_id',
                DB::raw('COUNT(*) as total_commandes'),
                DB::raw('SUM(montant) as montant_total')
            )
            ->with('user')
            ->groupBy('user_id')
            ->orderBy('montant_total', 'desc')
            ->take(5)
            ->get();
            
        return view('vendeur.statistiques', compact(
            'stats',
            'ventesParMois',
            'produitsPopulaires',
            'clientsFideles'
        ));
    }
    
    /**
     * Afficher les paramètres du vendeur
     */
    public function parametres()
    {
        $user = Auth::user();
        $boutique = $user->boutique;
        
        if (!$boutique) {
            return redirect()->route('vendeur.boutique.create');
        }
        
        return view('vendeur.parametres', compact('user', 'boutique'));
    }
    
    /**
     * Mettre à jour les paramètres du vendeur
     */
    public function updateParametres(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:100',
            'code_postal' => 'required|string|max:20',
            'pays' => 'required|string|max:100',
            'newsletter' => 'boolean',
            'notifications_email' => 'boolean',
            'notifications_sms' => 'boolean',
        ]);
        
        $user->update($validated);
        
        return back()->with('success', 'Vos paramètres ont été mis à jour avec succès');
    }
}
