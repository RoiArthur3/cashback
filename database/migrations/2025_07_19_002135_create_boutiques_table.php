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
        Schema::dropIfExists('boutiques');
        Schema::create('boutiques', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('categorie')->nullable();
            $table->text('description')->nullable();
            $table->string('offre')->nullable(); // offre spéciale/promotion
            $table->text('a_propos')->nullable(); // présentation du marchand
            $table->string('livraison')->nullable(); // délai de livraison
            $table->string('zone_livraison')->nullable(); // zones desservies
            $table->unsignedBigInteger('user_id')->nullable(); // propriétaire (partenaire)
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boutiques');
    }
};
