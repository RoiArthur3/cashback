<?php

use App\Models\Boutique;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Magasin;
use App\Models\TypeVente;
use App\Models\TypeMonture;
use App\Models\User;
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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nomproduit')->unique();
            $table->string('slug')->unique();
            $table->string('marque')->nullable();
            $table->string('couleur')->nullable();
            $table->mediumText('description')->nullable();
            $table->string('prix');
            $table->string('reductionprix')->nullable();
            $table->string('qty');
            $table->string('image');
            $table->text('images')->nullable();
            $table->string('video')->nullable();
            $table->string('statut');
            $table->boolean('en_vedette')->default(false);
            $table->boolean('en_vedetteimg')->default(false);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Categorie::class);
            $table->foreignIdFor(Boutique::class);
            $table->string('taille_id')->nullable();
            $table->string('pointure_id')->nullable();
            $table->boolean('black_friday_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
