<?php

namespace Database\Seeders;

use App\Models\Boutique;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BoutiqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boutiques = [
            [
                'nom' => 'TechShop',
                'slug' => 'techshop',
                'description' => 'Votre magasin de technologie préféré avec les dernières innovations',
                'logo' => 'boutiques/techshop-logo.png',
                'cashback_min' => 2.5,
                'cashback_max' => 5.0,
                'actif' => true,
                'note_moyenne' => 4.5,
                'nb_avis' => 124,
            ],
            [
                'nom' => 'FashionStyle',
                'slug' => 'fashionstyle',
                'description' => 'Mode tendance pour hommes et femmes',
                'logo' => 'boutiques/fashionstyle-logo.png',
                'cashback_min' => 3.0,
                'cashback_max' => 8.0,
                'actif' => true,
                'note_moyenne' => 4.2,
                'nb_avis' => 89,
            ],
            [
                'nom' => 'BeautyLux',
                'slug' => 'beautylux',
                'description' => 'Produits de beauté et soins de luxe',
                'logo' => 'boutiques/beautylux-logo.png',
                'cashback_min' => 4.0,
                'cashback_max' => 10.0,
                'actif' => true,
                'note_moyenne' => 4.7,
                'nb_avis' => 156,
            ],
            [
                'nom' => 'Home & Deco',
                'slug' => 'home-deco',
                'description' => 'Décoration et ameublement pour votre intérieur',
                'logo' => 'boutiques/homedeco-logo.png',
                'cashback_min' => 2.0,
                'cashback_max' => 6.5,
                'actif' => true,
                'note_moyenne' => 4.3,
                'nb_avis' => 67,
            ],
            [
                'nom' => 'SportPlus',
                'slug' => 'sportplus',
                'description' => 'Équipement sportif pour tous les sports',
                'logo' => 'boutiques/sportplus-logo.png',
                'cashback_min' => 3.5,
                'cashback_max' => 7.5,
                'actif' => true,
                'note_moyenne' => 4.6,
                'nb_avis' => 112,
            ],
        ];

        foreach ($boutiques as $boutique) {
            Boutique::create($boutique);
        }
    }
}
