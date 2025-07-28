<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campagnes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // annonceur/commerçant
            $table->string('titre');
            $table->string('media')->nullable();
            $table->string('lien');
            $table->string('texte_accroche')->nullable();
            $table->decimal('budget', 12, 2);
            $table->decimal('cout_unitaire', 8, 2);
            $table->integer('volume');
            $table->enum('statut', ['en_attente', 'active', 'terminee', 'suspendue', 'refusee'])->default('en_attente');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('campagnes');
    }
};
