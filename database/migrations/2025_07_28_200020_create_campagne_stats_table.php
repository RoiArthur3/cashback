<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campagne_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campagne_id');
            $table->integer('impressions')->default(0);
            $table->integer('clics')->default(0);
            $table->integer('conversions')->default(0);
            $table->integer('ventes')->default(0);
            $table->timestamps();
            $table->foreign('campagne_id')->references('id')->on('campagnes')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('campagne_stats');
    }
};
