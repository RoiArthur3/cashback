<?php

use App\Models\Boutique;
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
        Schema::create('black_fridays', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Boutique::class);
            $table->boolean('is_active')->default(false); // Black Friday activé ou non
            $table->integer('percentage')->nullable(); // Pourcentage de réduction
            $table->string('image')->nullable();
            $table->mediumText('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('black_fridays');
    }
};
