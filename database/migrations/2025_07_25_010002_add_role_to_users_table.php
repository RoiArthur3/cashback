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
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('client')->after('password');
            });
        } else {
            // Si la colonne existe déjà, s'assurer qu'elle a la bonne valeur par défaut
            DB::statement("ALTER TABLE `users` MODIFY COLUMN `role` VARCHAR(255) DEFAULT 'client'");
        }
    }

    public function down()
    {
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};