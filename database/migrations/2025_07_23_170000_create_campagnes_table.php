<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampagnesTable extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('campagnes');
        Schema::create('campagnes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('annonceur_id')->nullable();
            $table->string('titre');
            $table->string('type');
            $table->string('cible')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->decimal('budget', 10, 2)->nullable();
            $table->string('statut')->default('brouillon');
            $table->text('resultats')->nullable();
            $table->timestamps();
            
            // Ajout de la clé étrangère uniquement si la table users existe
            if (Schema::hasTable('users')) {
                $table->foreign('annonceur_id')->references('id')->on('users');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campagnes');
    }
}
