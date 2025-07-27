<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cashbacks', function (Blueprint $table) {
            $table->enum('statut', ['en_attente', 'valide', 'litige'])->default('en_attente')->after('montant');
            $table->timestamp('date_confirmation')->nullable()->after('statut');
        });
    }

    public function down(): void
    {
        Schema::table('cashbacks', function (Blueprint $table) {
            $table->dropColumn(['statut', 'date_confirmation']);
        });
    }
};
