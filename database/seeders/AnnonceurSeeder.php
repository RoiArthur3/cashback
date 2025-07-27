<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

class AnnonceurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crée ou met à jour le compte annonceur
        $annonceur = User::updateOrCreate(
            ['email' => 'annonceur@example.com'],
            [
                'name' => 'Jean Dupont',
                'password' => Hash::make('secret123'),
            ]
        );
        
        // Récupère le rôle annonceur
        $roleAnnonceur = Role::where('name', 'annonceur')->first();
        
        // Assure que le rôle existe
        if (!$roleAnnonceur) {
            $roleAnnonceur = Role::create([
                'name' => 'annonceur',
                'description' => 'Annonceur pouvant créer et gérer des campagnes publicitaires',
            ]);
        }
        
        // Attache le rôle à l'utilisateur s'il ne l'a pas déjà
        if ($roleAnnonceur && !$annonceur->roles()->where('name', 'annonceur')->exists()) {
            $annonceur->roles()->attach($roleAnnonceur->getKey());
        }
    }
}
