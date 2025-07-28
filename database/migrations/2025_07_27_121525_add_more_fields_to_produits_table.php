<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            // Champs de base
            if (!Schema::hasColumn('produits', 'reference')) {
                $table->string('reference')->unique()->after('id');
            }
            if (!Schema::hasColumn('produits', 'slug')) {
                $table->string('slug')->unique()->after('nom');
            }
            if (!Schema::hasColumn('produits', 'description_courte')) {
                $table->text('description_courte')->nullable()->after('description');
            }
            if (!Schema::hasColumn('produits', 'caracteristiques')) {
                $table->json('caracteristiques')->nullable()->after('description_courte');
            }

            // Prix et TVA
            if (!Schema::hasColumn('produits', 'prix_compare')) {
                $table->decimal('prix_compare', 10, 2)->nullable()->after('prix');
            }
            if (!Schema::hasColumn('produits', 'prix_promotionnel')) {
                $table->decimal('prix_promotionnel', 10, 2)->nullable()->after('prix_compare');
            }
            if (!Schema::hasColumn('produits', 'taux_tva')) {
                $table->decimal('taux_tva', 5, 2)->default(20.00)->after('prix_promotionnel');
            }

            // Dimensions et poids
            if (!Schema::hasColumn('produits', 'poids')) {
                $table->decimal('poids', 10, 3)->nullable()->after('taux_tva');
            }
            if (!Schema::hasColumn('produits', 'longueur')) {
                $table->decimal('longueur', 10, 2)->nullable()->after('poids');
            }
            if (!Schema::hasColumn('produits', 'largeur')) {
                $table->decimal('largeur', 10, 2)->nullable()->after('longueur');
            }
            if (!Schema::hasColumn('produits', 'hauteur')) {
                $table->decimal('hauteur', 10, 2)->nullable()->after('largeur');
            }
            if (!Schema::hasColumn('produits', 'unite_mesure')) {
                $table->string('unite_mesure', 20)->default('cm')->after('hauteur');
            }

            // Gestion des stocks
            if (!Schema::hasColumn('produits', 'stock')) {
                $table->integer('stock')->default(0)->after('unite_mesure');
            }
            if (!Schema::hasColumn('produits', 'stock_alerte')) {
                $table->integer('stock_alerte')->default(5)->after('stock');
            }
            if (!Schema::hasColumn('produits', 'gestion_stock')) {
                $table->boolean('gestion_stock')->default(true)->after('stock_alerte');
            }

            // Statuts et indicateurs
            if (!Schema::hasColumn('produits', 'actif')) {
                $table->boolean('actif')->default(true)->after('gestion_stock');
            }
            if (!Schema::hasColumn('produits', 'en_vedette')) {
                $table->boolean('en_vedette')->default(false)->after('actif');
            }
            if (!Schema::hasColumn('produits', 'nouveau')) {
                $table->boolean('nouveau')->default(true)->after('en_vedette');
            }
            if (!Schema::hasColumn('produits', 'meilleure_vente')) {
                $table->boolean('meilleure_vente')->default(false)->after('nouveau');
            }
            if (!Schema::hasColumn('produits', 'en_promotion')) {
                $table->boolean('en_promotion')->default(false)->after('meilleure_vente');
            }

            // Dates de promotion
            if (!Schema::hasColumn('produits', 'date_debut_promotion')) {
                $table->timestamp('date_debut_promotion')->nullable()->after('en_promotion');
            }
            if (!Schema::hasColumn('produits', 'date_fin_promotion')) {
                $table->timestamp('date_fin_promotion')->nullable()->after('date_debut_promotion');
            }

            // Évaluations
            if (!Schema::hasColumn('produits', 'note_moyenne')) {
                $table->decimal('note_moyenne', 2, 1)->default(0)->after('date_fin_promotion');
            }
            if (!Schema::hasColumn('produits', 'nombre_avis')) {
                $table->integer('nombre_avis')->default(0)->after('note_moyenne');
            }
            
            // SEO
            if (!Schema::hasColumn('produits', 'meta_titre')) {
                $table->string('meta_titre')->nullable()->after('nombre_avis');
            }
            if (!Schema::hasColumn('produits', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_titre');
            }
            if (!Schema::hasColumn('produits', 'meta_keywords')) {
                $table->text('meta_keywords')->nullable()->after('meta_description');
            }

            // Tags et catégorisation avancée
            if (!Schema::hasColumn('produits', 'tags')) {
                $table->json('tags')->nullable()->after('meta_keywords');
            }
            
            // Clés étrangères
            if (!Schema::hasColumn('produits', 'categorie_id')) {
                $table->foreignId('categorie_id')->after('boutique_id')->nullable()->constrained('categories')->nullOnDelete();
            }

            // Index
            $table->index(['actif', 'en_vedette']);
            $table->index(['actif', 'nouveau']);
            $table->index(['actif', 'meilleure_vente']);
            $table->index(['actif', 'en_promotion']);
            if (!Schema::hasColumn('produits', 'categorie_id')) {
                $table->index('categorie_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            // Suppression des colonnes ajoutées
            $columnsToDrop = [
                'reference', 'slug', 'description_courte', 'caracteristiques',
                'prix_compare', 'prix_promotionnel', 'taux_tva', 'poids',
                'longueur', 'largeur', 'hauteur', 'unite_mesure', 'stock',
                'stock_alerte', 'gestion_stock', 'actif', 'en_vedette', 'nouveau',
                'meilleure_vente', 'en_promotion', 'date_debut_promotion',
                'date_fin_promotion', 'note_moyenne', 'nombre_avis', 'meta_titre',
                'meta_description', 'meta_keywords', 'tags', 'categorie_id'
            ];
            
            // Suppression des contraintes de clé étrangère
            if (Schema::hasColumn('produits', 'categorie_id')) {
                $table->dropForeign(['categorie_id']);
            }
            
            // Suppression des index
            $indexesToDrop = [
                'produits_actif_en_vedette_index',
                'produits_actif_nouveau_index',
                'produits_actif_meilleure_vente_index',
                'produits_actif_en_promotion_index',
                'produits_categorie_id_index',
            ];
            
            foreach ($indexesToDrop as $index) {
                if (Schema::hasIndex('produits', $index)) {
                    $table->dropIndex($index);
                }
            }
            
            // Suppression des colonnes
            $table->dropColumn($columnsToDrop);
        });
    }
};
