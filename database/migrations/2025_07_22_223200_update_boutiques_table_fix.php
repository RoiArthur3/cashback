<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('boutiques', function (Blueprint $table) {
            // Vérifier si les colonnes n'existent pas déjà avant de les ajouter
            if (!Schema::hasColumn('boutiques', 'banniere')) {
                $table->string('banniere')->nullable()->after('logo');
            }
            
            if (!Schema::hasColumn('boutiques', 'couleur_principale')) {
                $table->string('couleur_principale', 7)->default('#3490dc')->after('banniere');
            }
            
            if (!Schema::hasColumn('boutiques', 'couleur_secondaire')) {
                $table->string('couleur_secondaire', 7)->default('#6c757d')->after('couleur_principale');
            }
            
            if (!Schema::hasColumn('boutiques', 'reseaux_sociaux')) {
                $table->json('reseaux_sociaux')->nullable()->after('couleur_secondaire');
            }
            
            if (!Schema::hasColumn('boutiques', 'statut')) {
                $table->enum('statut', ['en_attente', 'actif', 'suspendu'])->default('en_attente')->after('reseaux_sociaux');
            }
            
            // Renommer user_id en partenaire_id si nécessaire
            if (Schema::hasColumn('boutiques', 'user_id') && !Schema::hasColumn('boutiques', 'partenaire_id')) {
                $table->renameColumn('user_id', 'partenaire_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('boutiques', function (Blueprint $table) {
            // Ne supprimer que les colonnes que nous avons ajoutées
            $columnsToDrop = [
                'banniere',
                'couleur_principale',
                'couleur_secondaire',
                'reseaux_sociaux',
                'statut'
            ];
            
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('boutiques', $column)) {
                    $table->dropColumn($column);
                }
            }
            
            // Revenir au nom de colonne d'origine si nécessaire
            if (Schema::hasColumn('boutiques', 'partenaire_id')) {
                $table->renameColumn('partenaire_id', 'user_id');
            }
        });
    }
};
