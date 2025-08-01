<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('produits');
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boutique_id');
            $table->string('nom');
            $table->text('description')->nullable();
            $table->decimal('prix', 10, 2);
            $table->string('image')->nullable();
            $table->timestamps();
            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
