// Routes Troc (échange entre membres)
Route::resource('trocs', App\Http\Controllers\TrocController::class);
Route::post('trocs/{troc}/offres', [App\Http\Controllers\TrocController::class, 'proposerOffre'])->name('trocs.proposerOffre');
Route::post('trocs/{troc}/offres/{offre}/accepter', [App\Http\Controllers\TrocController::class, 'accepterOffre'])->name('trocs.accepterOffre');
Route::post('trocs/{troc}/offres/{offre}/refuser', [App\Http\Controllers\TrocController::class, 'refuserOffre'])->name('trocs.refuserOffre');
// Route pour les nouveautés (produits ou boutiques)
Route::get('/nouveautes', [App\Http\Controllers\BoutiqueController::class, 'nouveautes'])->name('nouveautes');
// Route publique pour la liste de mariage (accès accueil, bouton, etc.)
use App\Http\Controllers\ListeMariageController;
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\CashbackController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AcheteurController;
use App\Http\Controllers\KdoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListeMariageController;

// Route publique pour la page Bons plans (Deals)
Route::get('/deals', function() {
    // À remplacer par la logique réelle d'affichage des deals
    return view('deals.index');
})->name('deals');

// Route publique pour la page Troc (pour le header et l'inscription)
Route::get('/troc', function() {
    $trocs = collect(); // À remplacer par la logique réelle
    return view('account.troc', compact('trocs'));
})->name('troc.index');

// Route principale pour la liste de mariage (deux noms pour compatibilité)
// Route unique pour la page d'accueil des listes de mariage (compatible avec les deux noms)
// Route::get('/liste-mariage', [ListeMariageController::class, 'index'])->name('wedding-list.index');
/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
*/

// Page d'accueil publique
Route::get('/', [HomeController::class, 'index'])->name('home');

// Page d'assistance/support
Route::get('/support', function() {
    return view('support');
})->name('support');

// Routes d'authentification Laravel

Auth::routes();

// Route publique pour afficher le profil utilisateur (corrige l'erreur de route dans le menu)
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');

// Page d'accueil (accessible uniquement aux utilisateurs connectés)
Route::middleware(['auth'])->group(function () {
    Route::get('/accueil', [BuyerController::class, 'index'])->name('accueil');
});

// Routes publiques (sans authentification)
Route::get('/produits', [ProduitController::class, 'index'])->name('products.index');
Route::get('/boutiques', [BoutiqueController::class, 'index'])->name('boutiques.index');
Route::get('/boutiques/{boutique}', [BoutiqueController::class, 'show'])->name('boutique.show');
Route::get('/produits/{produit}', [ProduitController::class, 'show'])
    ->middleware('track.views')
    ->name('produits.show');
Route::get('/cashbacks', [CashbackController::class, 'index'])->name('cashbacks.index');

// Routes du panier
Route::middleware(['auth'])->group(function () {
    Route::get('/panier', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/panier/ajouter', [App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
    Route::put('/panier/{rowId}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/panier/{rowId}', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/panier/vider', [App\Http\Controllers\CartController::class, 'empty'])->name('cart.empty');
});

// Routes de recherche
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/boutiques/search', [BoutiqueController::class, 'search'])->name('boutiques.search');

// Routes pour les listes de mariage
Route::prefix('liste-mariage')->name('liste-mariage.')->group(function () {
    // Routes publiques (sans authentification)
    Route::get('/{liste:slug}', [ListeMariageController::class, 'show'])->name('show');
    Route::post('/{liste}/verifier-mot-de-passe', [ListeMariageController::class, 'verifierMotDePasse'])->name('verifier-mot-de-passe');
    
    // Routes protégées (authentification requise)
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [ListeMariageController::class, 'index'])->name('index');
        Route::get('/creer', [ListeMariageController::class, 'create'])->name('create');
        Route::post('/', [ListeMariageController::class, 'store'])->name('store');
        Route::get('/{liste}', [ListeMariageController::class, 'edit'])->name('edit');
        Route::put('/{liste}', [ListeMariageController::class, 'update'])->name('update');
        Route::delete('/{liste}', [ListeMariageController::class, 'destroy'])->name('destroy');
        
        // Gestion des produits dans la liste
        Route::post('/{liste}/produits', [ListeMariageController::class, 'ajouterProduit'])->name('produits.store');
        Route::delete('/{liste}/produits/{produit}', [ListeMariageController::class, 'supprimerProduit'])->name('produits.destroy');
        Route::put('/{liste}/produits/{produit}', [ListeMariageController::class, 'mettreAJourProduit'])->name('produits.update');
    });
});

// Routes protégées (authentification requise)
Route::middleware(['auth'])->group(function () {
    // Tableau de bord par défaut (redirige vers le bon tableau de bord en fonction du rôle)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [BuyerController::class, 'notifications'])->name('index');
        Route::post('/{id}/read', [BuyerController::class, 'markNotificationAsRead'])->name('markAsRead');
        Route::post('/read-all', [BuyerController::class, 'markAllNotificationsAsRead'])->name('markAllAsRead');
        Route::delete('/{id}', [BuyerController::class, 'deleteNotification'])->name('delete');
        Route::delete('/', [BuyerController::class, 'clearNotifications'])->name('clear');
    });
    
    // Gestion des favoris
    Route::prefix('favorites')->name('favorites.')->group(function () {
        Route::get('/', [BuyerController::class, 'favorites'])->name('index');
        Route::post('/{produit}', [BuyerController::class, 'addToFavorites'])->name('store');
        Route::delete('/{favorite}', [BuyerController::class, 'removeFromFavorites'])->name('destroy');
    });
    
    // Route de secours pour les anciens liens
    Route::get('/{id}/dashboard_{dashboardId}', function() {
        return redirect()->route('dashboard');
    })->where(['id' => '[0-9]+', 'dashboardId' => '[0-9]+']);
    
    // Espace Mon compte (accessible à tous les utilisateurs connectés)
    Route::prefix('mon-compte')->name('account.')->group(function () {
        Route::get('/', function() {
            return view('account.dashboard');
        })->name('dashboard');
        
        Route::get('/cashbacks', function() {
            $user = Auth::user();
            $cashbacks = $user->achats()->with('produit')->get();
            return view('account.cashbacks', compact('cashbacks'));
        })->name('cashbacks');
        
        Route::get('/commandes', function() {
            $user = Auth::user();
            $orders = $user->achats()->with(['produit', 'boutique'])->orderBy('created_at', 'desc')->get();
            return view('account.orders', compact('orders'));
        })->name('orders.index');
        
        Route::get('/listes-de-mariage', function() {
            $user = Auth::user();
            // Logique pour récupérer les listes de mariage
            $weddingLists = collect(); // Temporaire
            return view('account.wedding-lists', compact('weddingLists'));
        })->name('wedding-lists');
        // Alias pour compatibilité éventuelle
        Route::get('/listes-de-mariage', function() {
            $user = Auth::user();
            $weddingLists = collect();
            return view('account.wedding-lists', compact('weddingLists'));
        })->name('liste_mariage');
        
        Route::get('/troc', function() {
            $user = Auth::user();
            // Logique pour récupérer les trocs
            $trocs = collect(); // Temporaire
            return view('account.troc', compact('trocs'));
        })->name('troc');
        
        Route::get('/cercles', function() {
            $user = Auth::user();
            // Logique pour récupérer les cercles
            $circles = collect(); // Temporaire
            return view('account.circles', compact('circles'));
        })->name('circles');
        
        Route::get('/messagerie', function() {
            $user = Auth::user();
            // Logique pour récupérer les conversations
            $conversations = collect(); // Temporaire
            $unreadCount = 3; // Temporaire
            return view('account.messages', compact('conversations', 'unreadCount'));
        })->name('messages');
        
        Route::get('/parametres', function() {
            return view('account.settings');
        })->name('settings');
        
        Route::post('/parametres', function() {
            // Logique de mise à jour des paramètres
            return redirect()->route('account.settings')->with('success', 'Paramètres mis à jour');
        })->name('settings.update');
        
        // Ma boutique (pour commerçants et partenaires)
        Route::get('/boutique', [BoutiqueController::class, 'accountBoutique'])->name('boutique');
    });
    
    // Gestion des boutiques (création, édition)
    Route::get('/boutiques/create', [BoutiqueController::class, 'create'])->name('boutiques.create');
    Route::post('/boutiques', [BoutiqueController::class, 'store'])->name('boutiques.store');
    Route::get('/boutiques/{boutique}/edit', [BoutiqueController::class, 'edit'])->name('boutiques.edit');
    Route::post('/boutiques/{boutique}/update', [BoutiqueController::class, 'update'])->name('boutiques.update');
    
    // Avis sur boutiques
    Route::post('/boutiques/{boutique}/avis', [AvisController::class, 'store'])->name('boutique.avis.store');
    
    // Kdo surprise
    Route::post('/kdo-surprise', [KdoController::class, 'store'])->name('kdo.surprise');
});

// Routes spécifiques par rôle

// Espace Acheteur

// Route cagnotte accessible globalement (pour header universel)
Route::get('/cagnotte', function() {
    return view('acheteur.cagnotte');
})->name('cagnotte');

Route::middleware(['auth', 'role:acheteur'])->prefix('acheteur')->name('acheteur.')->group(function () {
    Route::get('/', [AcheteurController::class, 'dashboard'])->name('dashboard');
    Route::get('/profil', [AcheteurController::class, 'profil'])->name('profil');
    Route::post('/profil', [AcheteurController::class, 'update'])->name('update');
    Route::get('/achats', function() { 
        return view('acheteur.achats'); 
    })->name('achats');
    // Route /cagnotte reste accessible globalement
});

// Interface acheteur dédiée (nouvelle)
Route::middleware(['auth', 'role:acheteur'])->get('/buyer', [BuyerController::class, 'index'])->name('buyer.index');

// Espace Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestion des utilisateurs
    Route::get('/users', function() {
        $users = \App\Models\User::with('roles')->paginate(20);
        return view('admin.users', compact('users'));
    })->name('users');
    
    // Gestion des boutiques
    Route::get('/boutiques', function() {
        $boutiques = \App\Models\Boutique::with('partenaire')->paginate(20);
        return view('admin.boutiques', compact('boutiques'));
    })->name('boutiques');

    // Gestion des cashbacks
    Route::get('/cashbacks', [\App\Http\Controllers\Admin\CashbackController::class, 'index'])->name('cashbacks.index');
    Route::post('/cashbacks/{cashback}/valider', [\App\Http\Controllers\Admin\CashbackController::class, 'valider'])->name('cashbacks.valider');
    Route::post('/cashbacks/{cashback}/rembourser', [\App\Http\Controllers\Admin\CashbackController::class, 'rembourser'])->name('cashbacks.rembourser');
    Route::get('/cashbacks/{cashback}/accuse', [\App\Http\Controllers\Admin\CashbackController::class, 'accuse'])->name('cashbacks.accuse');
    
    // Comptabilité
    Route::get('/comptabilite', [\App\Http\Controllers\Admin\ComptabiliteController::class, 'index'])->name('comptabilite.index');
    

});

// Catégories de boutiques (accessible publiquement)
Route::get('/boutiques/categories', function() {
    $categories = \App\Models\Categorie::with('boutiques')->get();
    return view('admin.boutiques.categories', compact('categories'));
})->name('boutiques.categories');

// Espace Commerçant
Route::middleware(['auth', 'role:commercant'])->prefix('commercant')->name('commercant.')->group(function () {
    Route::get('/', function() {
        return view('commercant.dashboard');
    })->name('dashboard');
});

// Espace Boutique (pour les partenaires/commerçants)
Route::middleware(['auth', 'role:partenaire,commercant'])->prefix('boutique')->name('boutique.')->group(function () {
    Route::get('/cashbacks', [\App\Http\Controllers\Boutique\CashbackController::class, 'index'])->name('cashbacks.index');
    Route::get('/cashbacks/{cashback}/accuse', [\App\Http\Controllers\Boutique\CashbackController::class, 'accuse'])->name('cashbacks.accuse');
});

// Espace Partenaire
Route::middleware(['auth', 'role:partenaire'])->prefix('partenaire')->name('partenaire.')->group(function () {
    Route::get('/', function() {
        return view('partenaire.dashboard');
    })->name('dashboard');
});

// Espace Annonceur
Route::middleware(['auth', 'role:annonceur'])->prefix('annonceur')->name('annonceur.')->group(function () {
    Route::get('/', function() {
        return view('annonceur.dashboard');
    })->name('dashboard');
    // Gestion des campagnes publicitaires
    Route::resource('campagnes', App\Http\Controllers\Annonceur\CampagneController::class);
});

// Inclure les routes de rôles additionnelles si elles existent
if (file_exists(__DIR__.'/role_routes.php')) {
    require __DIR__.'/role_routes.php';
}
