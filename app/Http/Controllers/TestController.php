<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boutique;
use App\Models\Produit;

class TestController extends Controller
{
    public function createTestData()
    {
        // Création de boutiques de test
        $boutiques = [
            [
                'nom' => 'Tech & Co',
                'slug' => 'tech-co',
                'description' => 'Votre spécialiste en high-tech et accessoires',
                'logo' => 'https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'couverture' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80',
                'ville' => 'Abidjan',
                'quartier' => 'Cocody',
                'note' => 4.5,
                'nb_avis' => 128,
                'est_certifie' => true,
                'categories' => ['Électronique', 'High-Tech']
            ],
            [
                'nom' => 'Fashion Store',
                'slug' => 'fashion-store',
                'description' => 'Mode tendance pour hommes et femmes',
                'logo' => 'https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'couverture' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80',
                'ville' => 'Abidjan',
                'quartier' => 'Plateau',
                'note' => 4.2,
                'nb_avis' => 89,
                'est_certifie' => true,
                'categories' => ['Mode', 'Accessoires']
            ],
            [
                'nom' => 'Beauty Shop',
                'slug' => 'beauty-shop',
                'description' => 'Produits de beauté et cosmétiques naturels',
                'logo' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'couverture' => 'https://images.unsplash.com/photo-1522337360788-8b13de241667?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80',
                'ville' => 'Abidjan',
                'quartier' => 'Marcory',
                'note' => 4.7,
                'nb_avis' => 156,
                'est_certifie' => false,
                'categories' => ['Beauté', 'Soins']
            ]
        ];

        // Produits de test
        $produits = [
            // Produits Tech & Co
            [
                'nom' => 'Smartphone X Pro',
                'description' => 'Dernier modèle avec écran AMOLED et triple caméra',
                'prix' => 450000,
                'prix_promotion' => 399000,
                'image' => 'https://images.unsplash.com/photo-1611791484670-13dca5d2c1e5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'categorie' => 'Téléphonie',
                'badge' => 'Nouveau',
                'troc_possible' => true,
                'cashback' => 8,
                'boutique_slug' => 'tech-co'
            ],
            [
                'nom' => 'Écouteurs Sans Fil Pro',
                'description' => 'Réduction de bruit active et son haute qualité',
                'prix' => 120000,
                'prix_promotion' => 99000,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'categorie' => 'Audio',
                'badge' => 'Promo',
                'troc_possible' => false,
                'cashback' => 10,
                'boutique_slug' => 'tech-co'
            ],
            // Produits Fashion Store
            [
                'nom' => 'Veste en Cuir Classique',
                'description' => 'Veste en cuir véritable pour un style intemporel',
                'prix' => 85000,
                'prix_promotion' => 75000,
                'image' => 'https://images.unsplash.com/photo-1551028719-00167d1e06a5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'categorie' => 'Vêtements',
                'badge' => 'Tendance',
                'troc_possible' => true,
                'cashback' => 5,
                'boutique_slug' => 'fashion-store'
            ],
            // Produits Beauty Shop
            [
                'nom' => 'Kit Soin Visage Complet',
                'description' => 'Soin complet pour une peau éclatante',
                'prix' => 45000,
                'prix_promotion' => 39000,
                'image' => 'https://images.unsplash.com/photo-1625772452859-1c18313814ab?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'categorie' => 'Soins Visage',
                'badge' => 'Meilleure Vente',
                'troc_possible' => false,
                'cashback' => 7,
                'boutique_slug' => 'beauty-shop'
            ]
        ];

        // Retourner les données pour la vue
        return view('test.test-data', [
            'boutiques' => $boutiques,
            'produits' => $produits
        ]);
    }

    // Méthode pour afficher une boutique de test
    public function showTestBoutique($slug)
    {
        $boutiques = [
            'tech-co' => [
                'id' => 1,
                'nom' => 'Tech & Co',
                'slug' => 'tech-co',
                'description' => 'Votre spécialiste en high-tech et accessoires. Nous proposons les dernières innovations technologiques à des prix compétitifs avec un excellent service client.',
                'logo' => 'https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'couverture' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80',
                'ville' => 'Abidjan',
                'quartier' => 'Cocody',
                'note' => 4.5,
                'nb_avis' => 128,
                'est_certifie' => true,
                'categories' => ['Électronique', 'High-Tech'],
                'followers' => 2450,
                'produits_vendus' => 12500,
                'visiteurs_mensuels' => 15400
            ],
            'fashion-store' => [
                'id' => 2,
                'nom' => 'Fashion Store',
                'slug' => 'fashion-store',
                'description' => 'Mode tendance pour hommes et femmes. Découvrez nos nouvelles collections chaque saison.',
                'logo' => 'https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'couverture' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80',
                'ville' => 'Abidjan',
                'quartier' => 'Plateau',
                'note' => 4.2,
                'nb_avis' => 89,
                'est_certifie' => true,
                'categories' => ['Mode', 'Accessoires'],
                'followers' => 1870,
                'produits_vendus' => 9800,
                'visiteurs_mensuels' => 12400
            ],
            'beauty-shop' => [
                'id' => 3,
                'nom' => 'Beauty Shop',
                'slug' => 'beauty-shop',
                'description' => 'Produits de beauté et cosmétiques naturels pour prendre soin de vous au quotidien.',
                'logo' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'couverture' => 'https://images.unsplash.com/photo-1522337360788-8b13de241667?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80',
                'ville' => 'Abidjan',
                'quartier' => 'Marcory',
                'note' => 4.7,
                'nb_avis' => 156,
                'est_certifie' => false,
                'categories' => ['Beauté', 'Soins'],
                'followers' => 3120,
                'produits_vendus' => 15400,
                'visiteurs_mensuels' => 18700
            ]
        ];

        $boutique = $boutiques[$slug] ?? null;
        
        if (!$boutique) {
            abort(404);
        }

        // Produits de la boutique
        $produits = [
            [
                'id' => 1,
                'nom' => 'Smartphone X Pro',
                'description' => 'Dernier modèle avec écran AMOLED et triple caméra',
                'prix' => 450000,
                'prix_promotion' => 399000,
                'image' => 'https://images.unsplash.com/photo-1611791484670-13dca5d2c1e5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'categorie' => 'Téléphonie',
                'badge' => 'Nouveau',
                'troc_possible' => true,
                'cashback' => 8,
                'note' => 4.5,
                'nb_avis' => 45,
                'boutique_id' => 1
            ],
            [
                'id' => 2,
                'nom' => 'Écouteurs Sans Fil Pro',
                'description' => 'Réduction de bruit active et son haute qualité',
                'prix' => 120000,
                'prix_promotion' => 99000,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'categorie' => 'Audio',
                'badge' => 'Promo',
                'troc_possible' => false,
                'cashback' => 10,
                'note' => 4.8,
                'nb_avis' => 32,
                'boutique_id' => 1
            ],
            [
                'id' => 3,
                'nom' => 'Montre Connectée Elite',
                'description' => 'Suivi d\'activité et notifications intelligentes',
                'prix' => 180000,
                'prix_promotion' => 159000,
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'categorie' => 'Montres connectées',
                'badge' => 'Meilleure vente',
                'troc_possible' => true,
                'cashback' => 7,
                'note' => 4.6,
                'nb_avis' => 28,
                'boutique_id' => 1
            ],
            [
                'id' => 4,
                'nom' => 'Tablette Graphique',
                'description' => 'Idéale pour les créateurs et graphistes',
                'prix' => 250000,
                'prix_promotion' => 229000,
                'image' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'categorie' => 'Informatique',
                'badge' => 'Nouveauté',
                'troc_possible' => false,
                'cashback' => 6,
                'note' => 4.9,
                'nb_avis' => 18,
                'boutique_id' => 1
            ]
        ];

        // Filtrer les produits par boutique
        $produitsBoutique = array_filter($produits, function($produit) use ($boutique) {
            return $produit['boutique_id'] === $boutique['id'];
        });

        // Avis de test
        $avis = [
            [
                'id' => 1,
                'client_nom' => 'Aïcha K.',
                'client_photo' => 'https://randomuser.me/api/portraits/women/32.jpg',
                'note' => 5,
                'commentaire' => 'Livraison rapide et produit conforme à la description. Je recommande cette boutique !',
                'date' => 'Il y a 2 jours',
                'produit_nom' => 'Smartphone X Pro',
                'produit_image' => 'https://images.unsplash.com/photo-1611791484670-13dca5d2c1e5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80'
            ],
            [
                'id' => 2,
                'client_nom' => 'Moussa D.',
                'client_photo' => 'https://randomuser.me/api/portraits/men/45.jpg',
                'note' => 4,
                'commentaire' => 'Bon rapport qualité-prix, mais la livraison a pris plus de temps que prévu.',
                'date' => 'Il y a 1 semaine',
                'produit_nom' => 'Écouteurs Sans Fil Pro',
                'produit_image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80'
            ]
        ];

        return view('boutiques.show', [
            'boutique' => (object)$boutique,
            'produits' => $produitsBoutique,
            'avis' => $avis,
            'note' => $boutique['note'],
            'nbAvis' => $boutique['nb_avis'],
            'isCertified' => $boutique['est_certifie'],
            'localisation' => $boutique['ville'],
            'quartier' => $boutique['quartier'],
            'cover' => $boutique['couverture'],
            'logo' => $boutique['logo'],
            'followers' => $boutique['followers'],
            'produitsVendus' => $boutique['produits_vendus'],
            'visiteursMensuels' => $boutique['visiteurs_mensuels']
        ]);
    }
}
