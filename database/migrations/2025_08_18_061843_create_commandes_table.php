<?php

use App\Models\Boutique;
use App\Models\Produit;
use App\Models\User;
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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Boutique::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Produit::class)->constrained()->cascadeOnDelete();
            $table->string('adresseduclient')->nullable();
            $table->string('numeroduclient')->nullable();

            $table->unsignedInteger('qty');
            $table->unsignedInteger('price_fcfa');
            $table->unsignedInteger('total_fcfa');

            // Paiement minimal
            $table->enum('status', ['pending','paid','failed','canceled'])->default('pending');
            $table->string('payment_provider')->nullable(); // ex: cinetpay
            $table->string('payment_ref')->nullable();
            $table->timestamp('paid_at')->nullable();

            // Cashback (calculé à la création, crédité quand paid)
            $table->unsignedInteger('cashback_fcfa')->default(0);
            $table->timestamp('cashback_credited_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
