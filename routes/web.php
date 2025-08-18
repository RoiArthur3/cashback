<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KdoController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\AcheteurController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\CashbackController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MoncompteController;
use App\Http\Controllers\ParrainageController;
use App\Http\Controllers\BlackFridayController;
use App\Http\Controllers\WeddingListController;
use App\Http\Controllers\ListeMariageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\TypeBoutiqueController;

// Route publique pour la page Bons plans (Deals)
Route::get('/deals', function() {
    // À remplacer par la logique réelle d'affichage des deals
    return view('deals.index');
})->name('deals');

// Page principale de parrainage
// Route publique pour la page KDO Surprise
Route::get('/kdo', [KdoController::class, 'index'])->name('kdo');
Route::get('/parrainage', [ParrainageController::class, 'index'])->middleware('auth')->name('parrainage');

// Historique des filleuls
Route::get('/parrainage/filleuls', [ParrainageController::class, 'historique'])->middleware('auth')->name('parrainage.filleuls');

// Historique des gains
Route::get('/parrainage/gains', [ParrainageController::class, 'gains'])->middleware('auth')->name('parrainage.gains');

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

// Routes protégées (authentification requise)
Route::middleware(['auth'])->group(function () {

    // Espace Mon compte (accessible à tous les utilisateurs connectés)
    Route::prefix('mon-compte')->name('account.')->group(function () {
        Route::get('/', function() {
            return view('account.dashboard');
        })->name('dashboard');

        Route::get('/mes-commandes', [OrderController::class, 'index'])->name('orders.index');

        Route::get('/listes-de-mariage', [\App\Http\Controllers\ListeMariageController::class, 'index'])->name('wedding-lists');
        // Alias pour compatibilité avec les vues existantes
        Route::get('/listes-de-mariage', function() {
            $user = Auth::user();
            $weddingLists = collect();
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

        // Ma boutique (pour commerçants et partenaires)
        Route::get('/boutique', [BoutiqueController::class, 'accountBoutique'])->name('boutique');
    });

});

Route::get('/moncompte', [MoncompteController::class, 'moncompte'])->name('moncompte');
Route::post('/changepassword/update', [MoncompteController::class, 'updatepassword'])->name('updatepassword');
Route::post('/updateprofile/{id}', [MoncompteController::class, 'updateprofile'])->name('updateprofile');

Route::post('/boutique/panier/{boutiqueSlug}/add', [PanierController::class, 'add'])->name('cart.add');
Route::get('/boutique/panier/{boutiqueSlug}/count', [PanierController::class, 'count'])->name('cart.count');
Route::get('/boutique/panier/{boutiqueSlug}', [PanierController::class, 'lepanier'])->name('lepanier');
Route::patch('/panier/{boutiqueSlug}/item/{productId}', [PanierController::class, 'updateQty'])->name('cart.update');
Route::delete('/panier/{boutiqueSlug}/item/{productId}', [PanierController::class, 'remove'])->name('cart.remove');


//Client
Route::get('/lesboutiques', [HomeController::class, 'listesboutiques'])->name('lesboutiques');
Route::get('/boutique/{boutiqueSlug}', [HomeController::class, 'laboutique'])->name('laboutique');
Route::get('/boutique/{boutiqueSlug}/produit/{slug}',[HomeController::class,'leproduit'])->name('leproduit');
Route::get('/boutique/{boutiqueSlug}/categorie', [HomeController::class, 'lescategories'])->name('lescategories');
Route::get('/boutique/{boutiqueSlug}/categorie/{slug}', [HomeController::class, 'afficherParCategorie'])->name('categorie.produits');


// Espace Admin
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard.admin');
    Route::get('user',[UserController::class,'index'])->name('listeuser.admin');
    Route::get('user/create',[UserController::class,'create'])->name('createuser.admin');
    Route::delete('user/{id}',[UserController::class,'destroy'])->name('deleteuser.admin');
    Route::resource('typeboutique',TypeBoutiqueController::class);
    Route::resource('role',RoleController::class);

    Route::get('/boutiques',[BoutiqueController::class,'index'])->name('listmagasin.admin');
    Route::delete('/shop/{id}',[BoutiqueController::class,'destroy'])->name('boutique.destroy');
    Route::post('/shop/toggle-active/{id}', [BoutiqueController::class, 'toggleActive'])->name('boutique.toggleActive');
});


// Espace Commerçant
Route::prefix('commercant')->middleware('commercant')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard.commercant');
    Route::get('user',[UserController::class,'index'])->name('listeuser.commercant');
    Route::get('user/create',[UserController::class,'create'])->name('createuser.commercant');
    Route::get('user/edit/{id}',[UserController::class,'edit'])->name('edituser.commercant');
    Route::put('user/update/{id}',[UserController::class,'update'])->name('updateuser.commercant');
    Route::delete('user/{id}',[UserController::class,'destroy'])->name('deleteuser.commercant');

    Route::resource('categorie', CategorieController::class);
    Route::resource('produit', ProduitController::class);

    Route::get('/boutique/create', [BoutiqueController::class,'create'])->name('boutique.create');
    Route::post('/boutique/create', [BoutiqueController::class, 'store'])->name('boutique.store');
    Route::get('/boutique/edit/{id}', [BoutiqueController::class, 'edit'])->name('boutique.edit');
    Route::put('/boutique/update/{id}', [BoutiqueController::class, 'update'])->name('boutique.update');

    Route::get('/promotion', [BlackFridayController::class, 'index'])->name('black_friday.index');
    Route::get('/promotion/create', [BlackFridayController::class, 'create'])->name('black_friday.create');
    Route::post('/promotion/store', [BlackFridayController::class, 'store'])->name('black_friday.store');
    Route::post('/promotion/toggle', [BlackFridayController::class, 'toggle'])->name('black_friday.toggle');
    Route::get('/promotion/{id}', [BlackFridayController::class, 'edit'])->name('black_friday.edit');
    Route::put('/promotion/update/{id}', [BlackFridayController::class, 'update'])->name('black_friday.update');
    Route::delete('/promotion/{id}', [BlackFridayController::class, 'destroy'])->name('black_friday.destroy');
});


// Espace Partenaire

// Espace Annonceur

