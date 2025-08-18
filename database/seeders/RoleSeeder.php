<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'admin',
            'description' => 'Accès complet au système',
        ]);

        Role::create([
            'name' => 'client',
            'description' => 'Utilisateur standard',
        ]);

        Role::create([
            'name' => 'commercant',
            'description' => 'Gestionnaire de boutique',
        ]);

        Role::create([
            'name' => 'partenaire',
            'description' => 'Partenaire commercial',
        ]);

        Role::create([
            'name' => 'acheteur',
            'description' => 'Acheteur de produits',
        ]);

        Role::create([
            'name' => 'livreur',
            'description' => 'Service de livraison',
        ]);

        Role::create([
            'name' => 'vendeur',
            'description' => 'Vendeur de produits',
        ]);

        Role::create([
            'name' => 'gestionnaire',
            'description' => 'Gestion des opérations',
        ]);

        Role::create([
            'name' => 'annonceur',
            'description' => 'Gestion des publicités',
        ]);
    }
}
