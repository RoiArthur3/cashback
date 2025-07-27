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
            if (!Schema::hasColumn('boutiques', 'theme')) {
                $table->string('theme')->nullable()->after('user_id');
            }
            
            if (!Schema::hasColumn('boutiques', 'logo')) {
                $table->string('logo')->nullable()->after('theme');
            }
            
            if (!Schema::hasColumn('boutiques', 'slide_images')) {
                $table->json('slide_images')->nullable()->after('logo');
            }
            
            if (!Schema::hasColumn('boutiques', 'layout')) {
                $table->string('layout')->nullable()->after('slide_images');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boutiques', function (Blueprint $table) {
            $columnsToDrop = [];
            
            if (Schema::hasColumn('boutiques', 'theme')) {
                $columnsToDrop[] = 'theme';
            }
            
            if (Schema::hasColumn('boutiques', 'logo')) {
                $columnsToDrop[] = 'logo';
            }
            
            if (Schema::hasColumn('boutiques', 'slide_images')) {
                $columnsToDrop[] = 'slide_images';
            }
            
            if (Schema::hasColumn('boutiques', 'layout')) {
                $columnsToDrop[] = 'layout';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
