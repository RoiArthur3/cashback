<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('comptabilites', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // cashback, remboursement, paiement_boutique
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('boutique_id')->nullable();
            $table->unsignedBigInteger('cashback_id')->nullable();
            $table->decimal('montant', 10, 2);
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comptabilites');
    }
};
