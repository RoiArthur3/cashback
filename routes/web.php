<?php
use Illuminate\Support\Facades\Route;
use App\Models\Boutique;
use App\Http\Controllers\CashbackController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

// Espace Mon compte > Tableau de bord
Route::middleware(['auth'])->get('/mon-compte', function() {
    return view('account.dashboard');
})->name('account.dashboard');
// Espace Mon compte > Ma boutique
Route::middleware(['auth'])->get('/mon-compte/boutique', [BoutiqueController::class, 'accountBoutique'])->name('account.boutique');
// Edition de la boutique (accès propriétaire/partenaire)
Route::middleware(['auth'])->group(function () {
    Route::get('/boutiques/{boutique}/edit', [BoutiqueController::class, 'edit'])->name('boutiques.edit');
    Route::post('/boutiques/{boutique}/update', [BoutiqueController::class, 'update'])->name('boutiques.update');
});

Route::get('/boutiques/create', [BoutiqueController::class, 'create'])->name('boutiques.create');
Route::post('/boutiques', [BoutiqueController::class, 'store'])->name('boutiques.store');
Route::get('/cashbacks', [CashbackController::class, 'index'])->name('cashbacks.index');
// Route pour enregistrer un avis sur une boutique
Route::post('/boutiques/{boutique}/avis', [AvisController::class, 'store'])->name('boutique.avis.store');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/boutiques', [BoutiqueController::class, 'index'])->name('boutiques.index');
Route::get('/boutiques/{id}', [BoutiqueController::class, 'show'])->name('boutique.show');

// Routes d'authentification Laravel
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

require __DIR__.'/role_routes.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
