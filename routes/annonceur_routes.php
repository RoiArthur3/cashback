<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnonceurController;

Route::middleware(['auth', 'role:annonceur'])->group(function () {
    Route::get('/annonceur', [AnnonceurController::class, 'index'])->name('annonceur.dashboard');
    // Ajoutez ici d'autres routes annonceur si besoin
});
