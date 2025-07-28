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
        if (!Schema::hasTable('liste_mariage_produit')) {
            Schema::create('liste_mariage_produit', function (Blueprint $table) {
                $table->id();
                $table->foreignId('liste_mariage_id')->constrained('liste_mariages')->onDelete('cascade');
                $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
                $table->integer('quantite')->default(1);
                $table->integer('quantite_souhaitee')->default(1);
                $table->string('statut')->default('disponible'); // disponible, reserve, achete
                $table->text('message')->nullable();
                $table->integer('ordre')->default(0);
                $table->string('reserve_par')->nullable(); // Nom de la personne qui réserve
                $table->string('email_reservation')->nullable(); // Email de la personne qui réserve
                $table->text('message_reservation')->nullable(); // Message de la personne qui réserve
                $table->timestamp('date_reservation')->nullable();
                $table->timestamps();
                // Contrainte d'unicité pour éviter les doublons
                $table->unique(['liste_mariage_id', 'produit_id']);
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liste_mariage_produit');
    }
};
