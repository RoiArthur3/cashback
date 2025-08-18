<?php

use App\Models\User;
use App\Models\TypeBoutique;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('boutiques', function (Blueprint $table) {
            $table->id();
            $table->string('nommagasin')->unique();
            $table->string('slug')->unique();
            $table->string('contact');
            $table->string('adresse')->nullable();
            $table->string('email')->nullable();
            $table->string('registrecommerce')->nullable();
            $table->foreignIdFor(User::class)->onDelete('cascade')->nullable();
            $table->foreignIdFor(TypeBoutique::class);
            $table->string('image')->nullable();
            $table->string('imgmagasin')->nullable();
            $table->string('video')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('cashback_enabled')->default(false);
            $table->enum('cashback_type', ['percent','fixed'])->nullable()->after('cashback_enabled'); // percent = %, fixed = FCFA
            $table->unsignedInteger('cashback_value')->nullable()->after('cashback_type');            // 5 (%) ou 1000 (FCFA)
            $table->unsignedInteger('cashback_min_order')->nullable()->after('cashback_value');       // seuil mini en FCFA (ex: 10000)
            $table->string('description')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('whatsapp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boutiques');
    }
};
