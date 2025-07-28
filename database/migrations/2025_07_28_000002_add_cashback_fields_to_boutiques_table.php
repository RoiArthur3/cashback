<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('boutiques', function (Blueprint $table) {
            if (!Schema::hasColumn('boutiques', 'cashback_min')) {
                $table->float('cashback_min')->default(0)->after('slug');
            }
            if (!Schema::hasColumn('boutiques', 'cashback_max')) {
                $table->float('cashback_max')->default(0)->after('cashback_min');
            }
            if (!Schema::hasColumn('boutiques', 'actif')) {
                $table->boolean('actif')->default(true)->after('cashback_max');
            }
            if (!Schema::hasColumn('boutiques', 'note_moyenne')) {
                $table->float('note_moyenne')->default(0)->after('actif');
            }
            if (!Schema::hasColumn('boutiques', 'nb_avis')) {
                $table->integer('nb_avis')->default(0)->after('note_moyenne');
            }
        });
    }

    public function down(): void
    {
        Schema::table('boutiques', function (Blueprint $table) {
            $table->dropColumn(['cashback_min', 'cashback_max', 'actif', 'note_moyenne', 'nb_avis']);
        });
    }
};
