<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartenaireController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommercantController;
use App\Http\Controllers\ClientController;
// Gestion des produits de la boutique du partenaire
Route::get('/partenaire/produits', [PartenaireController::class, 'produits'])->name('partenaire.produits');
Route::get('/partenaire/produits/create', [PartenaireController::class, 'createProduit'])->name('partenaire.produits.create');
Route::post('/partenaire/produits/store', [PartenaireController::class, 'storeProduit'])->name('partenaire.produits.store');
Route::get('/partenaire/produits/{id}/edit', [PartenaireController::class, 'editProduit'])->name('partenaire.produits.edit');
Route::put('/partenaire/produits/{id}/update', [PartenaireController::class, 'updateProduit'])->name('partenaire.produits.update');
Route::delete('/partenaire/produits/{id}/delete', [PartenaireController::class, 'deleteProduit'])->name('partenaire.produits.delete');
// Gestion des cashbacks de la boutique du partenaire
Route::get('/partenaire/cashbacks', [PartenaireController::class, 'cashbacks'])->name('partenaire.cashbacks');
Route::get('/partenaire/cashbacks/create', [PartenaireController::class, 'createCashback'])->name('partenaire.cashbacks.create');
Route::post('/partenaire/cashbacks/store', [PartenaireController::class, 'storeCashback'])->name('partenaire.cashbacks.store');
Route::get('/partenaire/cashbacks/{id}/edit', [PartenaireController::class, 'editCashback'])->name('partenaire.cashbacks.edit');
Route::put('/partenaire/cashbacks/{id}/update', [PartenaireController::class, 'updateCashback'])->name('partenaire.cashbacks.update');
Route::delete('/partenaire/cashbacks/{id}/delete', [PartenaireController::class, 'deleteCashback'])->name('partenaire.cashbacks.delete');
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/boutiques', [AdminController::class, 'boutiques'])->name('admin.boutiques');
    Route::get('/admin/cashbacks', [AdminController::class, 'cashbacks'])->name('admin.cashbacks');
});

Route::middleware(['auth', 'role:commercant'])->group(function () {
    Route::get('/commercant', [CommercantController::class, 'index'])->name('commercant.dashboard');
    // Autres routes commerçant
});

Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client', [ClientController::class, 'index'])->name('client.dashboard');
    Route::get('/client/achats', [ClientController::class, 'achats'])->name('client.achats');
    // Autres routes client
});

Route::middleware(['auth', 'role:partenaire'])->group(function () {
    Route::get('/partenaire', [PartenaireController::class, 'index'])->name('partenaire.dashboard');
    Route::get('/partenaire/boutique/edit', [PartenaireController::class, 'edit'])->name('partenaire.boutique.edit');
    Route::post('/partenaire/boutique/update', [PartenaireController::class, 'update'])->name('partenaire.boutique.update');
    Route::delete('/partenaire/boutique/delete', [PartenaireController::class, 'destroy'])->name('partenaire.boutique.delete');
});
