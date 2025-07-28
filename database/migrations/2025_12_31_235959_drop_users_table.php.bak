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
        
        // Liste des tables qui pourraient avoir des clés étrangères vers users
        $tables = [
            'avis' => 'user_id',
            'achats' => 'user_id',
            'annonces' => 'annonceur_id',
            'paiements' => 'user_id',
            'soldes' => 'user_id',
            'role_user' => 'user_id',
            'boutiques' => 'user_id',
            'cashbacks' => 'user_id',
            'commandes' => 'user_id',
            'messages' => ['expediteur_id', 'destinataire_id']
        ];
        
        // Parcourir toutes les tables et supprimer les contraintes
        foreach ($tables as $table => $columns) {
            if (!Schema::hasTable($table)) {
                continue;
            }
            
            $columns = (array) $columns; // Convertir en tableau si une seule colonne
            
            foreach ($columns as $column) {
                if (Schema::hasColumn($table, $column)) {
                    // Récupérer le nom de la contrainte
                    $constraints = DB::select(
                        "SELECT CONSTRAINT_NAME 
                         FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                         WHERE TABLE_SCHEMA = ? 
                         AND TABLE_NAME = ? 
                         AND COLUMN_NAME = ? 
                         AND REFERENCED_TABLE_NAME = 'users'",
                        [config('database.connections.mysql.database'), $table, $column]
                    );
                    
                    foreach ($constraints as $constraint) {
                        if (!empty($constraint->CONSTRAINT_NAME)) {
                            try {
                                Schema::table($table, function (Blueprint $table) use ($constraint) {
                                    $table->dropForeign($constraint->CONSTRAINT_NAME);
                                });
                            } catch (\Exception $e) {
                                // Si dropForeign échoue, utiliser une requête brute
                                DB::statement("ALTER TABLE `{$table}` DROP FOREIGN KEY `{$constraint->CONSTRAINT_NAME}`");
<?php
// Migration désactivée pour éviter la suppression de la table users
// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     public function up(): void
//     {
//         Schema::dropIfExists('users');
//     }

//     public function down(): void
//     {
//         // Cette migration ne peut pas être annulée
//     }
// };
};
