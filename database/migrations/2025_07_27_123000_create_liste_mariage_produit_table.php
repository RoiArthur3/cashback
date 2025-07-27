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
        Schema::create('liste_mariage_produit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('liste_mariage_id')->constrained()->onDelete('cascade');
            $table->foreignId('produit_id')->constrained()->onDelete('cascade');
            $table->integer('quantite_demandee')->default(1);
            $table->integer('quantite_achetee')->default(0);
            $table->text('message')->nullable();
            $table->foreignId('achete_par')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Empêche les doublons de produits dans une même liste
            $table->unique(['liste_mariage_id', 'produit_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liste_mariage_produit');
    }
};
