<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('annonceur_id');
            $table->string('titre');
            $table->text('contenu');
            $table->string('image')->nullable();
            $table->string('lien')->nullable();
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->enum('statut', ['brouillon', 'actif', 'expire', 'desactive'])->default('brouillon');
            $table->decimal('cout', 10, 2)->default(0);
            $table->integer('vues')->default(0);
            $table->integer('clics')->default(0);
            $table->timestamps();

            $table->foreign('annonceur_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
