<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Boutique;
use App\Models\Produit;

class TestBoutiquesSeeder extends Seeder
{
    public function run()
    {
        // Crée un compte commerçant de test

        $commercant = User::firstOrCreate([
            'email' => 'commercant@test.com'
        ], [
            'name' => 'Commerçant Test',
            'password' => bcrypt('password'),
        ]);

        // Associe le rôle commerçant via la table de pivot
        $role = \App\Models\Role::where('name', 'commercant')->first();
        if ($role && !$commercant->roles()->where('name', 'commercant')->exists()) {
            $commercant->roles()->attach($role->id);
        }

        // Crée 3 boutiques liées au commerçant
        for ($i = 1; $i <= 3; $i++) {
            $boutique = Boutique::create([
                'nom' => "Boutique Test $i",
                'description' => "Description de la boutique $i",
                'user_id' => $commercant->id,
            ]);

            // Crée 5 produits pour chaque boutique
            for ($j = 1; $j <= 5; $j++) {
                Produit::create([
                    'nom' => "Produit $j Boutique $i",
                    'prix' => rand(1000, 10000),
                    'boutique_id' => $boutique->id,
                ]);
            }
        }
    }
}
