<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Désactiver temporairement les vérifications de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Supprimer la contrainte de la table role_user si elle existe
        if (Schema::hasTable('role_user') && Schema::hasColumn('role_user', 'role_id')) {
            Schema::table('role_user', function (Blueprint $table) {
                $table->dropForeign(['role_id']);
            });
        }
        
        // Supprimer la table roles
        Schema::dropIfExists('roles');
        
        // Réactiver les vérifications de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down(): void
    {
        // Impossible de restaurer sans structure
    }
};
