<?php

namespace Database\Seeders;

use App\Models\Campagne;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CampagneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vérifier s'il y a déjà des campagnes
        if (DB::table('campagnes')->count() > 0) {
            $this->command->info('Des campagnes existent déjà. Aucune donnée de test n\'a été ajoutée.');
            return;
        }

        // Vérifier si la table users existe
        if (!Schema::hasTable('users')) {
            $this->command->info('La table users n\'existe pas. Création d\'un ID d\'annonceur par défaut.');
            $annonceurId = 1; // ID par défaut
        } else {
            // Récupérer l'ID de l'annonceur
            $annonceurId = DB::table('users')
                ->where('email', 'annonceur@example.com')
                ->value('id');

            if (!$annonceurId) {
                $this->command->info('Aucun annonceur trouvé. Utilisation d\'un ID par défaut.');
                $annonceurId = 1; // ID par défaut
            }
        }

        $campagnes = [
            [
                'annonceur_id' => $annonceurId,
                'titre' => 'Promotion Été 2025',
                'type' => 'promotion',
                'cible' => 'tous',
                'date_debut' => now()->subDays(5),
                'date_fin' => now()->addDays(25),
                'budget' => 5000.00,
                'statut' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'annonceur_id' => $annonceurId,
                'titre' => 'Nouveaux Produits',
                'type' => 'nouveaute',
                'cible' => 'clients_frequents',
                'date_debut' => now()->subDays(2),
                'date_fin' => now()->addDays(30),
                'budget' => 3000.00,
                'statut' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'annonceur_id' => $annonceurId,
                'titre' => 'Soldes Spéciales',
                'type' => 'soldes',
                'cible' => 'nouveaux_clients',
                'date_debut' => now()->subDays(10),
                'date_fin' => now()->addDays(5),
                'budget' => 2000.00,
                'statut' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('campagnes')->insert($campagnes);
        $this->command->info('Campagnes de test créées avec succès !');
    }
}
