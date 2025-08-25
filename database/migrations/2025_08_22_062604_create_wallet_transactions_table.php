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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('commande_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['credit','debit','adjustment']);
            $table->enum('source', ['cashback','redeem','withdraw','adjust']);
            $table->unsignedBigInteger('amount_fcfa');      // toujours positif
            $table->string('description')->nullable();
            $table->string('idempotency_key')->nullable()->unique(); // pour éviter doubles crédits
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
