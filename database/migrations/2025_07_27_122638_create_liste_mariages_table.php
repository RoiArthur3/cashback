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
        Schema::create('liste_mariages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->date('date_mariage');
            $table->string('image_couverture')->nullable();
            $table->enum('statut', ['brouillon', 'active', 'terminee', 'archivee'])->default('brouillon');
            $table->string('url_personnalisee')->unique();
            $table->text('message_remerciement')->nullable();
            $table->text('adresse_livraison')->nullable();
            $table->string('telephone_contact')->nullable();
            $table->string('email_contact')->nullable();
            $table->string('theme')->default('classique');
            $table->string('couleur_principale')->default('#4f46e5');
            $table->string('couleur_secondaire')->default('#818cf8');
            $table->string('mot_de_passe')->nullable();
            $table->boolean('est_publique')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liste_mariages');
    }
};
