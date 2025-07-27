<?php

namespace Database\Seeders;

use App\Models\Produit;
use App\Models\Boutique;
use App\Models\Categorie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vérifier s'il y a déjà des produits
        if (Produit::count() > 0) {
            return;
        }

        // Récupérer les boutiques et catégories existantes
        $boutiques = Boutique::all();
        $categories = Categorie::all();

        if ($boutiques->isEmpty() || $categories->isEmpty()) {
            $this->command->info('Veuillez d\'abord créer des boutiques et des catégories.');
            return;
        }

        // Produits en promotion
        $promoProducts = [
            [
                'nom' => 'Smartphone Premium',
                'description' => 'Dernier modèle avec appareil photo haute résolution',
                'prix' => 999.99,
                'prix_promotionnel' => 799.99,
                'image_url' => 'https://via.placeholder.com/300?text=Smartphone+Premium',
                'en_promotion' => true,
                'date_debut_promotion' => now(),
                'date_fin_promotion' => now()->addDays(7),
            ],
            [
                'nom' => 'Casque Audio Sans Fil',
                'description' => 'Réduction de bruit active, qualité sonore exceptionnelle',
                'prix' => 249.99,
                'prix_promotionnel' => 199.99,
                'image_url' => 'https://via.placeholder.com/300?text=Casque+Audio',
                'en_promotion' => true,
                'date_debut_promotion' => now(),
                'date_fin_promotion' => now()->addDays(3),
            ],
            [
                'nom' => 'Montre Connectée',
                'description' => 'Suivi d\'activité et notifications intelligentes',
                'prix' => 199.99,
                'prix_promotionnel' => 149.99,
                'image_url' => 'https://via.placeholder.com/300?text=Montre+Connectée',
                'en_promotion' => true,
                'date_debut_promotion' => now(),
                'date_fin_promotion' => now()->addDays(5),
            ],
        ];

        // Produits normaux
        $normalProducts = [
            [
                'nom' => 'Ordinateur Portable',
                'description' => 'Puissant ordinateur portable pour le travail et les jeux',
                'prix' => 1299.99,
                'image_url' => 'https://via.placeholder.com/300?text=Ordinateur+Portable',
            ],
            [
                'nom' => 'Tablette Graphique',
                'description' => 'Idéale pour les artistes numériques',
                'prix' => 349.99,
                'image_url' => 'https://via.placeholder.com/300?text=Tablette+Graphique',
            ],
            [
                'nom' => 'Enceinte Bluetooth',
                'description' => 'Son puissant et portable',
                'prix' => 129.99,
                'image_url' => 'https://via.placeholder.com/300?text=Enceinte+Bluetooth',
            ],
            [
                'nom' => 'Clavier Mécanique',
                'description' => 'Pour une expérience de frappe optimale',
                'prix' => 89.99,
                'image_url' => 'https://via.placeholder.com/300?text=Clavier+Mécanique',
            ],
            [
                'nom' => 'Souris Ergonomique',
                'description' => 'Confortable pour une utilisation prolongée',
                'prix' => 59.99,
                'image_url' => 'https://via.placeholder.com/300?text=Souris+Ergonomique',
            ],
        ];

        // Créer les produits en promotion
        foreach ($promoProducts as $productData) {
            $product = new Produit($productData);
            $product->boutique_id = $boutiques->random()->id;
            $product->categorie_id = $categories->random()->id;
            $product->slug = Str::slug($product->nom);
            $product->save();
        }

        // Créer les produits normaux
        foreach ($normalProducts as $productData) {
            $product = new Produit($productData);
            $product->boutique_id = $boutiques->random()->id;
            $product->categorie_id = $categories->random()->id;
            $product->slug = Str::slug($product->nom);
            $product->save();
        }
    }
}
