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
        Schema::table('produits', function (Blueprint $table) {
            $table->boolean('en_promotion')->default(false)->after('image');
            $table->decimal('prix_promotionnel', 10, 2)->nullable()->after('en_promotion');
            $table->dateTime('date_debut_promotion')->nullable()->after('prix_promotionnel');
            $table->dateTime('date_fin_promotion')->nullable()->after('date_debut_promotion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropColumn([
                'en_promotion',
                'prix_promotionnel',
                'date_debut_promotion',
                'date_fin_promotion'
            ]);
        });
    }
};
