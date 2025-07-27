<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('montant', 10, 2);
            $table->string('reference')->unique();
            $table->enum('type', ['entree', 'sortie']);
            $table->enum('statut', ['en_attente', 'valide', 'annule', 'refuse'])->default('en_attente');
            $table->string('methode')->nullable();
            $table->text('details')->nullable();
            $table->timestamp('date_validation')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Table pour suivre les soldes des utilisateurs
        Schema::create('soldes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->decimal('montant', 10, 2)->default(0);
            $table->decimal('montant_en_attente', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soldes');
        Schema::dropIfExists('paiements');
    }
};
