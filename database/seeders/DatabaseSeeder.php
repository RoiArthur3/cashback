<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Suppression désactivée pour éviter les erreurs de tables manquantes
        
        // Appeler les seeders
        $this->call(RoleSeeder::class);
        $this->call(BoutiqueSeeder::class);
        
        // Compte admin par défaut
        $admin = User::firstOrCreate(
            ['email' => 'admin@cbm.local'],
            [
                'name' => 'Admin CBM',
                'password' => bcrypt('admin1234'),
            ]
        );
        
        // Associer le rôle admin
        $roleAdmin = \App\Models\Role::where('name', 'admin')->first();
        if ($roleAdmin && !$admin->roles()->where('name', 'admin')->exists()) {
            $admin->roles()->attach($roleAdmin->getKey());
        }
        
        // Créer un autre compte admin
        $admin2 = User::firstOrCreate(
            ['email' => 'admin2@cbm.local'],
            [
                'name' => 'Admin Secondaire',
                'password' => bcrypt('admin2345'),
            ]
        );
        
        if ($roleAdmin && !$admin2->roles()->where('name', 'admin')->exists()) {
            $admin2->roles()->attach($roleAdmin->getKey());
        }
        
        // Compte acheteur par défaut
        $acheteur = User::firstOrCreate(
            ['email' => 'buyer@cbm.local'],
            [
                'name' => 'Acheteur Test',
                'password' => bcrypt('acheteur1234'),
            ]
        );
        
        // Associer le rôle acheteur si non déjà associé
        $roleAcheteur = \App\Models\Role::where('name', 'acheteur')->first();
        if ($roleAcheteur && !$acheteur->roles()->where('name', 'acheteur')->exists()) {
            $acheteur->roles()->attach($roleAcheteur->getKey());
        }
        
        // Créer ou mettre à jour l'utilisateur d'id 2 pour test dashboard universel
        $user2 = User::firstOrCreate(
            ['email' => 'acheteur2@cbm.local'],
            [
                'name' => 'Acheteur Deux',
                'password' => bcrypt('acheteur2345'),
            ]
        );
        
        if ($roleAcheteur && !$user2->roles()->where('name', 'acheteur')->exists()) {
            $user2->roles()->attach($roleAcheteur->getKey());
        }
        
        // Créer le compte annonceur
        $this->call(AnnonceurSeeder::class);
        
        // Peupler la table des campagnes
        $this->call(CampagneSeeder::class);
        
        // Attribuer le rôle client à tous les users sans rôle (sécurité)
        $this->call(UserRoleSeeder::class);
    }
}
