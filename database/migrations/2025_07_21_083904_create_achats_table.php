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
        Schema::create('achats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('produit_id');
            $table->unsignedBigInteger('boutique_id');
            $table->decimal('montant', 10, 2);
            $table->decimal('cashback', 10, 2)->default(0);
            $table->enum('statut', ['en_attente', 'valide', 'refuse'])->default('en_attente');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('produit_id')->references('id')->on('produits')->onDelete('cascade');
            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achats', function (Blueprint $table) {
            $table->dropForeign(['produit_id']);
        });
        Schema::dropIfExists('achats');
    }
};
