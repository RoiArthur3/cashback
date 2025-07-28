<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campagne_ciblages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campagne_id');
            $table->string('critere'); // ex: sexe, age, localisation, etc.
            $table->string('valeur'); // ex: Homme, 25-35, Abidjan, etc.
            $table->timestamps();
            $table->foreign('campagne_id')->references('id')->on('campagnes')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('campagne_ciblages');
    }
};
