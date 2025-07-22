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
        Schema::table('boutiques', function (Blueprint $table) {
            $table->string('theme')->nullable()->after('user_id');
            $table->string('logo')->nullable()->after('theme');
            $table->json('slide_images')->nullable()->after('logo');
            $table->string('layout')->nullable()->after('slide_images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boutiques', function (Blueprint $table) {
            $table->dropColumn(['theme', 'logo', 'slide_images', 'layout']);
        });
    }
};
