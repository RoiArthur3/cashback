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
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('display_name')->nullable();
                $table->string('description')->nullable();
                $table->timestamps();
            });

            // Insérer les rôles de base
            DB::table('roles')->insert([
                ['name' => 'admin', 'display_name' => 'Administrateur', 'description' => 'Accès complet au système', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'client', 'display_name' => 'Client', 'description' => 'Utilisateur standard', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'commercant', 'display_name' => 'Commerçant', 'description' => 'Gestionnaire de boutique', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'partenaire', 'display_name' => 'Partenaire', 'description' => 'Partenaire commercial', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'acheteur', 'display_name' => 'Acheteur', 'description' => 'Acheteur de produits', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'livreur', 'display_name' => 'Livreur', 'description' => 'Service de livraison', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'vendeur', 'display_name' => 'Vendeur', 'description' => 'Vendeur de produits', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'gestionnaire', 'display_name' => 'Gestionnaire', 'description' => 'Gestion des opérations', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'annonceur', 'display_name' => 'Annonceur', 'description' => 'Gestion des publicités', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_table_if_not_exists');
    }
};
