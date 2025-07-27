<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            // Ajouter categorie_id si elle n'existe pas
            if (!Schema::hasColumn('produits', 'categorie_id')) {
                $table->foreignId('categorie_id')
                    ->nullable()
                    ->constrained()
                    ->onDelete('set null');
            }
            
            // Ajouter slug si elle n'existe pas
            if (!Schema::hasColumn('produits', 'slug')) {
                $table->string('slug')
                    ->unique()
                    ->after('nom');
            }
            
            // Ajouter prix_compare si elle n'existe pas
            if (!Schema::hasColumn('produits', 'prix_compare')) {
                $table->decimal('prix_compare', 12, 2)
                    ->nullable()
                    ->after('prix');
            }
            
            // Ajouter stock si elle n'existe pas
            if (!Schema::hasColumn('produits', 'stock')) {
                $table->integer('stock')
                    ->default(0)
                    ->after('image');
            }
            
            // Ajouter promotion si elle n'existe pas
            if (!Schema::hasColumn('produits', 'promotion')) {
                $table->integer('promotion')
                    ->nullable()
                    ->after('stock');
            }
            
            // Ajouter nouveau si elle n'existe pas
            if (!Schema::hasColumn('produits', 'nouveau')) {
                $table->boolean('nouveau')
                    ->default(false)
                    ->after('promotion');
            }
            
            // Ajouter meilleure_vente si elle n'existe pas
            if (!Schema::hasColumn('produits', 'meilleure_vente')) {
                $table->boolean('meilleure_vente')
                    ->default(false)
                    ->after('nouveau');
            }
            
            // Ajouter note_moyenne si elle n'existe pas
            if (!Schema::hasColumn('produits', 'note_moyenne')) {
                $table->decimal('note_moyenne', 2, 1)
                    ->default(0)
                    ->after('meilleure_vente');
            }
            
            // Ajouter nombre_avis si elle n'existe pas
            if (!Schema::hasColumn('produits', 'nombre_avis')) {
                $table->integer('nombre_avis')
                    ->default(0)
                    ->after('note_moyenne');
            }
            
            // Ajouter statut si elle n'existe pas
            if (!Schema::hasColumn('produits', 'statut')) {
                $table->string('statut')
                    ->default('actif')
                    ->after('nombre_avis');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $columnsToDrop = [];
            
            // Supprimer la clé étrangère si elle existe
            if (Schema::hasColumn('produits', 'categorie_id')) {
                $columnsToDrop[] = 'categorie_id';
                
                // Récupérer le nom de la contrainte de clé étrangère
                $foreignKeys = DB::select(
                    "SELECT CONSTRAINT_NAME 
                     FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                     WHERE TABLE_SCHEMA = ? 
                     AND TABLE_NAME = 'produits' 
                     AND COLUMN_NAME = 'categorie_id' 
                     AND CONSTRAINT_NAME <> 'PRIMARY'",
                    [config('database.connections.mysql.database')]
                );
                
                foreach ($foreignKeys as $key) {
                    $table->dropForeign([$key->CONSTRAINT_NAME]);
                }
            }
            
            // Liste des colonnes à supprimer si elles existent
            $possibleColumns = [
                'slug',
                'prix_compare',
                'stock',
                'promotion',
                'nouveau',
                'meilleure_vente',
                'note_moyenne',
                'nombre_avis',
                'statut'
            ];
            
            foreach ($possibleColumns as $column) {
                if (Schema::hasColumn('produits', $column)) {
                    $columnsToDrop[] = $column;
                }
            }
            
            // Supprimer les colonnes si nécessaire
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
