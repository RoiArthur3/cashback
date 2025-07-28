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
        if (!Schema::hasTable('liste_mariages')) {
            Schema::create('liste_mariages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('titre');
                $table->text('description')->nullable();
                $table->date('date_mariage');
                $table->string('image_couverture')->nullable();
                $table->string('statut')->default('brouillon'); // brouillon, active, desactivee, archivee
                $table->string('url_personnalisee')->unique()->nullable();
                $table->text('message_remerciement')->nullable();
                $table->text('adresse_livraison');
                $table->string('telephone_contact');
                $table->string('email_contact');
                $table->string('theme')->default('classique'); // classique, moderne, romantique, naturel
                $table->string('couleur_principale')->default('#F59E0B'); // Couleur principale du thème
                $table->string('couleur_secondaire')->default('#D97706'); // Couleur secondaire du thème
                $table->string('mot_de_passe')->nullable(); // Mot de passe optionnel pour accéder à la liste
                $table->boolean('est_publique')->default(true); // Si la liste est visible publiquement
                $table->boolean('notifications_par_email')->default(true); // Si l'utilisateur souhaite recevoir des notifications
                $table->timestamp('date_activation')->nullable();
                $table->integer('vues')->default(0);
                $table->timestamps();
                $table->softDeletes();
                // Index pour les recherches
                $table->index(['statut', 'est_publique']);
                $table->index('url_personnalisee');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liste_mariages');
    }
};
