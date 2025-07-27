<?php

namespace Database\Seeders;

use App\Models\Produit;
use App\Models\Boutique;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProduitsTableSeeder extends Seeder
{
    /**
     * Exécute le seeder pour créer des produits de test.
     */
    public function run(): void
    {
        $faker = Faker::create('fr_FR');
        
        // Vérifier s'il existe des boutiques
        if (Boutique::count() === 0) {
            // Créer une boutique par défaut si aucune n'existe
            $boutique = Boutique::create([
                'nom' => 'Boutique de démonstration',
                'description' => 'Une boutique de démonstration pour les tests',
                'adresse' => '123 Rue de la Démo',
                'telephone' => '0123456789',
                'email' => 'demo@boutique.com',
                'user_id' => 1, // Assurez-vous qu'un utilisateur avec cet ID existe
            ]);
            $boutiqueId = $boutique->id;
        } else {
            $boutiqueId = Boutique::first()->id;
        }
        
        // Catégories de produits
        $categories = [
            'Électronique', 'Mode', 'Maison', 'Beauté', 'Sport', 'Loisirs', 
            'Jouets', 'Informatique', 'Téléphonie', 'Cuisine'
        ];
        
        // Créer 20 produits de test
        for ($i = 1; $i <= 20; $i++) {
            Produit::create([
                'boutique_id' => $boutiqueId,
                'nom' => $faker->words(3, true),
                'description' => $faker->paragraph(3),
                'prix' => $faker->randomFloat(2, 5, 1000),
                'categorie' => $faker->randomElement($categories),
                'image' => 'produit-' . $faker->numberBetween(1, 10) . '.jpg',
                'en_promotion' => false, // On laisse le seeder de promotion s'occuper de ça
            ]);
        }
        
        $this->command->info('20 produits de test ont été créés avec succès.');
    }
}
