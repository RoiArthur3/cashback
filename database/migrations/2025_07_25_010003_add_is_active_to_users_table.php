<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Vérifier si la colonne n'existe pas déjà
        if (!Schema::hasColumn('users', 'is_active')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('role');
            });
        } else {
            // Si la colonne existe déjà, s'assurer qu'elle a la bonne valeur par défaut
            DB::statement("ALTER TABLE `users` MODIFY COLUMN `is_active` TINYINT(1) DEFAULT 1");
        }
    }

    public function down()
    {
        if (Schema::hasColumn('users', 'is_active')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
    }
};