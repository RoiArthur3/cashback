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
        // Désactiver temporairement les vérifications de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Suppression des contraintes de clé étrangère si elles existent
        if (Schema::hasTable('role_user')) {
            // Vérifier et supprimer les contraintes de clé étrangère
            $constraints = DB::select(
                "SELECT 
                    CONSTRAINT_NAME,
                    COLUMN_NAME
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = ? 
                AND TABLE_NAME = 'role_user' 
                AND REFERENCED_TABLE_NAME IS NOT NULL
                AND CONSTRAINT_NAME <> 'PRIMARY'",
                [config('database.connections.mysql.database')]
            );
            
            foreach ($constraints as $constraint) {
                if (!empty($constraint->CONSTRAINT_NAME)) {
                    try {
                        Schema::table('role_user', function (Blueprint $table) use ($constraint) {
                            $table->dropForeign([$constraint->COLUMN_NAME]);
                        });
                    } catch (\Exception $e) {
                        // Ignorer les erreurs si la contrainte n'existe pas
                        continue;
                    }
                }
            }
        }
        
        // Suppression des tables dans le bon ordre (DÉSACTIVÉ pour éviter la suppression des tables pivot et rôles)
        // Schema::dropIfExists('role_user');
        // Schema::dropIfExists('roles');
        
        // Réactiver les vérifications de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cette migration ne peut pas être annulée car elle supprime des données
        // Il faudrait recréer les tables et les données manuellement
    }
};
