<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register() {
        // Aucune liaison nécessaire ici pour le modèle Role
    }

    /**
     * Bootstrap any application services.
     */
    public function boot() {
        // Autres configurations si nécessaire
    }
}
