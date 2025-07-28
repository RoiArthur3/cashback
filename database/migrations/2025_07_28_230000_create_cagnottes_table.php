<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cagnottes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('liste_mariage_id');
            $table->decimal('montant_total', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('liste_mariage_id')->references('id')->on('liste_mariages')->onDelete('cascade');
        });
        Schema::create('cagnotte_contributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cagnotte_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nom_contributeur')->nullable();
            $table->decimal('montant', 10, 2);
            $table->string('message')->nullable();
            $table->timestamps();

            $table->foreign('cagnotte_id')->references('id')->on('cagnottes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cagnotte_contributions');
        Schema::dropIfExists('cagnottes');
    }
};
