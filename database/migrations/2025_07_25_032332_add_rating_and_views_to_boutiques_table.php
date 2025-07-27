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
        Schema::table('boutiques', function (Blueprint $table) {
            if (!Schema::hasColumn('boutiques', 'note_moyenne')) {
                $table->decimal('note_moyenne', 3, 2)->default(0);
            }
            
            if (!Schema::hasColumn('boutiques', 'vues')) {
                $table->unsignedInteger('vues')->default(0);
            }
            
            if (!Schema::hasColumn('boutiques', 'taux_cashback')) {
                $table->decimal('taux_cashback', 5, 2)->default(0);
            }
            
            // Ne pas ajouter la colonne statut si elle existe déjà
            if (!Schema::hasColumn('boutiques', 'statut')) {
                $table->string('statut', 20)->default('actif');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boutiques', function (Blueprint $table) {
            $columnsToDrop = [];
            
            if (Schema::hasColumn('boutiques', 'note_moyenne')) {
                $columnsToDrop[] = 'note_moyenne';
            }
            
            if (Schema::hasColumn('boutiques', 'vues')) {
                $columnsToDrop[] = 'vues';
            }
            
            if (Schema::hasColumn('boutiques', 'taux_cashback')) {
                $columnsToDrop[] = 'taux_cashback';
            }
            
            if (Schema::hasColumn('boutiques', 'statut') && !in_array('statut', $columnsToDrop)) {
                $columnsToDrop[] = 'statut';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
