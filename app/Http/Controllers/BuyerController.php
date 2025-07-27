<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Boutique;
use App\Models\Produit;
use App\Models\User;
use App\Models\Adresse;
use App\Models\Categorie;
use App\Models\Cashback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BuyerController extends Controller
{
    /**
     * Affiche la page d'accueil de l'acheteur.
     */
    public function index()
    {
        // Données pour la section Hero (uniquement si connecté)
        $user = auth()->user();
        
        // Top 5 produits les plus vendus (par nombre d'achats)
        $topProduits = Produit::with('boutique')
            ->withCount('achats')
            ->orderByDesc('achats_count')
            ->take(5)
            ->get();
            
        // Meilleures boutiques (par note moyenne)
        $topBoutiques = Boutique::withAvg('avis', 'note')
            ->orderByDesc('avis_avg_note')
            ->take(6)
            ->get();
            
        // Catégories principales
        $categories = Categorie::take(6)->get();
        
        // Achats récents (si connecté)
        $achatsRecents = [];
        if ($user) {
            $achatsRecents = $user->achats()
                ->with(['produit.boutique'])
                ->latest()
                ->take(3)
                ->get();
        }
        
        // Produits en promotion
        $produitsEnPromo = Produit::where('en_promotion', true)
            ->where(function($query) {
                $now = now();
                $query->whereNull('date_debut_promotion')
                      ->orWhere('date_debut_promotion', '<=', $now);
            })
            ->where(function($query) {
                $now = now();
                $query->whereNull('date_fin_promotion')
                      ->orWhere('date_fin_promotion', '>=', $now);
            })
            ->inRandomOrder()
            ->take(4)
            ->get();
            
        // Si aucun produit en promotion, on en prend 4 aléatoires
        if ($produitsEnPromo->isEmpty()) {
            $produitsEnPromo = Produit::inRandomOrder()->take(4)->get();
            
            // Mettre à jour ces produits pour les marquer comme étant en promotion
            foreach ($produitsEnPromo as $produit) {
                $produit->update([
                    'en_promotion' => true,
                    'prix_promotionnel' => $produit->prix * 0.8, // 20% de réduction
                    'date_debut_promotion' => now(),
                    'date_fin_promotion' => now()->addDays(7)
                ]);
            }
        }
        
        // Statistiques (si connecté)
        $stats = [];
        if ($user) {
            $stats = [
                'total_commandes' => $user->achats()->count(),
                'total_cashback' => $user->cashback_total ?? 0,
                'commandes_ce_mois' => $user->achats()
                    ->whereMonth('created_at', now()->month)
                    ->count(),
            ];
        }

        return view('buyer.index', [
            'topProduits' => $topProduits,
            'topBoutiques' => $topBoutiques,
            'categories' => $categories,
            'commandes' => $achatsRecents,
            'produitsEnPromo' => $produitsEnPromo,
            'stats' => $stats,
            'user' => $user
        ]);
    }
    
    /**
     * Afficher le profil de l'acheteur
     */
    public function profil()
    {
        $user = Auth::user();
        $adresses = $user->adresses;
        $commandes = $user->achats()
            ->with(['produit.boutique'])
            ->latest()
            ->paginate(10);
            
        $cashbacks = $user->cashbacks()
            ->with(['boutique', 'achat.produit'])
            ->latest()
            ->paginate(10);
            
        return view('buyer.profil', compact('user', 'adresses', 'commandes', 'cashbacks'));
    }
    
    /**
     * Mettre à jour le profil de l'acheteur
     */
    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'telephone' => 'required|string|max:20',
            'date_naissance' => 'nullable|date|before:today',
            'genre' => 'nullable|in:homme,femme,autre',
            'newsletter' => 'boolean',
            'notifications_email' => 'boolean',
            'notifications_sms' => 'boolean',
        ]);
        
        // Gestion de l'avatar
        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            // Supprimer l'ancien avatar s'il existe
            if ($user->avatar) {
                \Storage::disk('public')->delete($user->avatar);
            }
            
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }
        
        $user->update($validated);
        
        return back()->with('success', 'Votre profil a été mis à jour avec succès');
    }
    
    /**
     * Afficher les commandes de l'acheteur
     */
    public function commandes()
    {
        $commandes = Auth::user()->achats()
            ->with(['produit.boutique'])
            ->latest()
            ->paginate(10);
            
        return view('buyer.commandes.index', compact('commandes'));
    }
    
    /**
     * Afficher les détails d'une commande
     */
    public function showCommande($id)
    {
        $commande = Achat::with(['produit.boutique', 'adresse'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);
            
        return view('buyer.commandes.show', compact('commande'));
    }
    
    /**
     * Afficher les cashbacks de l'acheteur
     */
    public function cashbacks()
    {
        $cashbacks = Auth::user()->cashbacks()
            ->with(['boutique', 'achat.produit'])
            ->latest()
            ->paginate(10);
            
        $stats = [
            'total' => Auth::user()->cashback_total,
            'disponible' => Auth::user()->cashback_disponible,
            'en_attente' => Auth::user()->cashbacks()->where('statut', 'en_attente')->sum('montant'),
            'valide' => Auth::user()->cashbacks()->where('statut', 'valide')->sum('montant'),
        ];
            
        return view('buyer.cashbacks.index', compact('cashbacks', 'stats'));
    }
    
    /**
     * Demander un retrait de cashback
     */
    public function demandeRetrait(Request $request)
    {
        $user = Auth::user();
        $montant = $request->input('montant');
        
        $request->validate([
            'montant' => 'required|numeric|min:5000|max:' . $user->cashback_disponible,
            'methode_paiement' => 'required|in:orange_money,mtn_money,wave',
            'numero_compte' => 'required|string|max:20',
        ]);
        
        // Créer la demande de retrait
        $retrait = $user->retraits()->create([
            'montant' => $montant,
            'methode_paiement' => $request->methode_paiement,
            'numero_compte' => $request->numero_compte,
            'statut' => 'en_attente',
            'frais' => $montant * 0.02, // 2% de frais
        ]);
        
        // Mettre à jour le solde disponible de l'utilisateur
        $user->decrement('cashback_disponible', $montant);
        
        // Marquer les cashbacks comme utilisés pour ce retrait
        $cashbacks = $user->cashbacks()
            ->where('statut', 'valide')
            ->where('utilise', false)
            ->orderBy('created_at')
            ->get();
            
        $montantRestant = $montant;
        
        foreach ($cashbacks as $cashback) {
            if ($montantRestant <= 0) break;
            
            $montantUtilise = min($cashback->montant_disponible, $montantRestant);
            
            $cashback->retraits()->attach($retrait->id, [
                'montant_utilise' => $montantUtilise,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $cashback->decrement('montant_disponible', $montantUtilise);
            $cashback->update(['utilise' => $cashback->montant_disponible <= 0]);
            
            $montantRestant -= $montantUtilise;
        }
        
        // Envoyer une notification à l'administrateur
        // Notification::send(User::where('role', 'admin')->get(), new RetraitDemande($retrait));
        
        return back()->with('success', 'Votre demande de retrait a été enregistrée. Elle sera traitée sous 24-48h.');
    }
    
    /**
     * Afficher les favoris de l'acheteur
     */
    public function favoris()
    {
        $favoris = Auth::user()->favoris()
            ->with(['produit.boutique'])
            ->latest()
            ->paginate(12);
            
        return view('buyer.favoris.index', compact('favoris'));
    }
    
    /**
     * Ajouter un produit aux favoris
     */
    public function ajouterFavori(Request $request, Produit $produit)
    {
        $user = Auth::user();
        
        if ($user->favoris()->where('produit_id', $produit->id)->exists()) {
            return response()->json(['message' => 'Ce produit est déjà dans vos favoris'], 422);
        }
        
        $user->favoris()->create([
            'produit_id' => $produit->id,
        ]);
        
        return response()->json([
            'message' => 'Produit ajouté aux favoris',
            'count' => $user->favoris()->count(),
        ]);
    }
    
    /**
     * Supprimer un produit des favoris
     */
    public function supprimerFavori(Produit $produit)
    {
        $user = Auth::user();
        $user->favoris()->where('produit_id', $produit->id)->delete();
        
        return response()->json([
            'message' => 'Produit retiré des favoris',
            'count' => $user->favoris()->count(),
        ]);
    }
    
    /**
     * Afficher les adresses de l'acheteur
     */
    public function adresses()
    {
        $adresses = Auth::user()->adresses;
        return view('buyer.adresses.index', compact('adresses'));
    }
    
    /**
     * Afficher le formulaire d'ajout d'adresse
     */
    public function createAdresse()
    {
        return view('buyer.adresses.create');
    }
    
    /**
     * Enregistrer une nouvelle adresse
     */
    public function storeAdresse(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'nom' => 'required|string|max:100',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'complement' => 'nullable|string|max:255',
            'code_postal' => 'required|string|max:20',
            'ville' => 'required|string|max:100',
            'pays' => 'required|string|max:100',
            'est_par_defaut' => 'boolean',
        ]);
        
        // Si c'est l'adresse par défaut, on désactive les autres
        if ($request->est_par_defaut) {
            Auth::user()->adresses()->update(['est_par_defaut' => false]);
        }
        
        Auth::user()->adresses()->create($validated);
        
        return redirect()->route('buyer.adresses')
            ->with('success', 'Adresse ajoutée avec succès');
    }
    
    /**
     * Afficher le formulaire de modification d'adresse
     */
    public function editAdresse(Adresse $adresse)
    {
        $this->authorize('update', $adresse);
        return view('buyer.adresses.edit', compact('adresse'));
    }
    
    /**
     * Mettre à jour une adresse
     */
    public function updateAdresse(Request $request, Adresse $adresse)
    {
        $this->authorize('update', $adresse);
        
        $validated = $request->validate([
            'libelle' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'nom' => 'required|string|max:100',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'complement' => 'nullable|string|max:255',
            'code_postal' => 'required|string|max:20',
            'ville' => 'required|string|max:100',
            'pays' => 'required|string|max:100',
            'est_par_defaut' => 'boolean',
        ]);
        
        // Si c'est l'adresse par défaut, on désactive les autres
        if ($request->est_par_defaut) {
            Auth::user()->adresses()
                ->where('id', '!=', $adresse->id)
                ->update(['est_par_defaut' => false]);
        }
        
        $adresse->update($validated);
        
        return redirect()->route('buyer.adresses')
            ->with('success', 'Adresse mise à jour avec succès');
    }
    
    /**
     * Supprimer une adresse
     */
    public function deleteAdresse(Adresse $adresse)
    {
        $this->authorize('delete', $adresse);
        
        // On ne peut pas supprimer l'adresse par défaut s'il n'y en a pas d'autre
        if ($adresse->est_par_defaut && Auth::user()->adresses()->count() > 1) {
            // On définit une autre adresse comme adresse par défaut
            $autreAdresse = Auth::user()->adresses()
                ->where('id', '!=', $adresse->id)
                ->first();
                
            if ($autreAdresse) {
                $autreAdresse->update(['est_par_defaut' => true]);
            }
        }
        
        $adresse->delete();
        
        return back()->with('success', 'Adresse supprimée avec succès');
    }
    
    /**
     * Afficher les paramètres de l'acheteur
     */
    public function parametres()
    {
        $user = Auth::user();
        return view('buyer.parametres', compact('user'));
    }
    
    /**
     * Mettre à jour les paramètres de l'acheteur
     */
    public function updateParametres(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'telephone' => 'required|string|max:20',
            'date_naissance' => 'nullable|date|before:today',
            'genre' => 'nullable|in:homme,femme,autre',
            'newsletter' => 'boolean',
            'notifications_email' => 'boolean',
            'notifications_sms' => 'boolean',
        ]);
        
        // Gestion du mot de passe
        if ($request->filled('password_actuel')) {
            $request->validate([
                'password_actuel' => ['required', 'current_password'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            
            $validated['password'] = bcrypt($request->password);
        }
        
        // Gestion de l'avatar
        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            // Supprimer l'ancien avatar s'il existe
            if ($user->avatar) {
                \Storage::disk('public')->delete($user->avatar);
            }
            
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }
        
        $user->update($validated);
        
        return back()->with('success', 'Vos paramètres ont été mis à jour avec succès');
    }
    
    /**
     * Afficher les notifications de l'acheteur
     */
    public function notifications()
    {
        $notifications = Auth::user()->notifications()
            ->latest()
            ->paginate(15);
            
        // Marquer les notifications comme lues
        Auth::user()->unreadNotifications->markAsRead();
            
        return view('buyer.notifications.index', compact('notifications'));
    }
    
    /**
     * Marquer une notification comme lue
     */
    public function markNotificationAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllNotificationsAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Supprimer une notification
     */
    public function deleteNotification($id)
    {
        Auth::user()->notifications()->findOrFail($id)->delete();
        
        return back()->with('success', 'Notification supprimée avec succès');
    }
    
    /**
     * Vider toutes les notifications
     */
    public function clearNotifications()
    {
        Auth::user()->notifications()->delete();
        
        return back()->with('success', 'Toutes les notifications ont été supprimées');
    }
    
    /**
     * Afficher les favoris de l'acheteur
     */
    public function favorites()
    {
        $favorites = Auth::user()->favorites()
            ->with(['produit' => function($query) {
                $query->with('boutique');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('buyer.favorites.index', compact('favorites'));
    }
    
    /**
     * Ajouter un produit aux favoris
     */
    public function addToFavorites(Produit $produit)
    {
        $user = Auth::user();
        
        // Vérifier si le produit est déjà dans les favoris
        if (!$user->favorites()->where('produit_id', $produit->id)->exists()) {
            $user->favorites()->create([
                'produit_id' => $produit->id
            ]);
            
            return back()->with('success', 'Produit ajouté à vos favoris');
        }
        
        return back()->with('info', 'Ce produit est déjà dans vos favoris');
    }
    
    /**
     * Retirer un produit des favoris
     */
    public function removeFromFavorites($favoriteId)
    {
        $favorite = Auth::user()->favorites()->findOrFail($favoriteId);
        $favorite->delete();
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'Produit retiré de vos favoris');
    }
}
