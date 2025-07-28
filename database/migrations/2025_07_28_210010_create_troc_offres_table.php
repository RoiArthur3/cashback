<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('troc_offres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('troc_id');
            $table->unsignedBigInteger('user_id');
            $table->text('description_offre');
            $table->enum('statut', ['en_attente', 'accepte', 'refuse'])->default('en_attente');
            $table->timestamps();
            $table->foreign('troc_id')->references('id')->on('trocs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('troc_offres');
    }
};
