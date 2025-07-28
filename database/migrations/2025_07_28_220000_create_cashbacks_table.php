<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cashbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('boutique_id')->nullable();
            $table->decimal('montant', 12, 2);
            $table->enum('statut', ['en_attente', 'valide', 'rembourse'])->default('en_attente');
            $table->enum('type', ['payin', 'payout'])->default('payin');
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('set null');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('cashbacks');
    }
};
