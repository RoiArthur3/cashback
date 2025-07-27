<?php
namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BoutiqueTestController extends Controller
{
    public function createDemoBoutiques()
    {
        // Création des catégories si elles n'existent pas
        $categories = [
            'Électronique', 'Mode', 'Maison', 'Beauté', 'Sport', 'Loisirs'
        ];
        
        foreach ($categories as $categorie) {
            Categorie::firstOrCreate(['nom' => $categorie]);
        }

        // Tableau des boutiques de démonstration
        $boutiques = [
            [
                'nom' => 'TechZone',
                'slug' => 'techzone',
                'description' => 'Votre destination high-tech pour les derniers gadgets électroniques',
                'categorie' => 'Électronique',
                'logo' => 'https://images.unsplash.com/photo-1593642634524-b40b5baae6bb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'ville' => 'Abidjan',
                'quartier' => 'Cocody',
                'taux_cashback' => 7.5,
                'livraison_gratuite' => true,
                'note_moyenne' => 4.7,
                'nombre_avis' => 245,
                'certifie' => true,
                'produits' => [
                    [
                        'nom' => 'Smartphone X Pro',
                        'description' => 'Dernier smartphone avec écran AMOLED 120Hz et triple caméra',
                        'prix' => 450000,
                        'prix_compare' => 499000,
                        'image' => 'https://images.unsplash.com/photo-1611791484673-13b62d8d1a90?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'stock' => 50,
                        'categorie' => 'Électronique',
                        'promotion' => 10,
                        'nouveau' => true,
                        'meilleure_vente' => true
                    ],
                    [
                        'nom' => 'Écouteurs Sans Fil Pro',
                        'description' => 'Écouteurs avec annulation de bruit active et autonomie de 30h',
                        'prix' => 125000,
                        'prix_compare' => 149900,
                        'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'stock' => 100,
                        'categorie' => 'Électronique',
                        'promotion' => 15,
                        'nouveau' => false,
                        'meilleure_vente' => true
                    ]
                ]
            ],
            [
                'nom' => 'Fashion Plus',
                'slug' => 'fashion-plus',
                'description' => 'Mode tendance pour hommes et femmes aux meilleurs prix',
                'categorie' => 'Mode',
                'logo' => 'https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1445205170230-053b83016042?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'ville' => 'Abidjan',
                'quartier' => 'Marcory',
                'taux_cashback' => 5.0,
                'livraison_gratuite' => true,
                'note_moyenne' => 4.5,
                'nombre_avis' => 189,
                'certifie' => true,
                'produits' => [
                    [
                        'nom' => 'Robe d\'été légère',
                        'description' => 'Robe légère et élégante pour l\'été, disponible en plusieurs coloris',
                        'prix' => 35000,
                        'prix_compare' => 45000,
                        'image' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'stock' => 30,
                        'categorie' => 'Mode',
                        'promotion' => 22,
                        'nouveau' => true,
                        'meilleure_vente' => false
                    ],
                    [
                        'nom' => 'Costume élégant',
                        'description' => 'Costume deux pièces pour homme, idéal pour les occasions spéciales',
                        'prix' => 125000,
                        'prix_compare' => 149900,
                        'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'stock' => 25,
                        'categorie' => 'Mode',
                        'promotion' => 15,
                        'nouveau' => false,
                        'meilleure_vente' => true
                    ]
                ]
            ],
            [
                'nom' => 'Home & Deco',
                'slug' => 'home-deco',
                'description' => 'Décoration et ameublement pour votre intérieur',
                'categorie' => 'Maison',
                'logo' => 'https://images.unsplash.com/photo-1616486338815-3d95d9597b4c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'ville' => 'Abidjan',
                'quartier' => 'Plateau',
                'taux_cashback' => 4.0,
                'livraison_gratuite' => false,
                'note_moyenne' => 4.6,
                'nombre_avis' => 132,
                'certifie' => true,
                'produits' => [
                    [
                        'nom' => 'Canapé d\'angle moderne',
                        'description' => 'Canapé d\'angle en tissu résistant, plusieurs coloris disponibles',
                        'prix' => 450000,
                        'prix_compare' => 525000,
                        'image' => 'https://images.unsplash.com/photo-1555041463-a586c061ea63?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'stock' => 15,
                        'categorie' => 'Maison',
                        'promotion' => 14,
                        'nouveau' => true,
                        'meilleure_vente' => true
                    ],
                    [
                        'nom' => 'Lampe de chevet design',
                        'description' => 'Lampe de chevet LED avec variateur d\'intensité',
                        'prix' => 35000,
                        'prix_compare' => 42500,
                        'image' => 'https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'stock' => 40,
                        'categorie' => 'Maison',
                        'promotion' => 18,
                        'nouveau' => true,
                        'meilleure_vente' => false
                    ]
                ]
            ]
        ];

        $createdBoutiques = [];
        
        foreach ($boutiques as $boutiqueData) {
            // Création de la boutique
            $boutique = Boutique::updateOrCreate(
                ['slug' => $boutiqueData['slug']],
                [
                    'nom' => $boutiqueData['nom'],
                    'description' => $boutiqueData['description'],
                    'categorie' => $boutiqueData['categorie'],
                    'logo' => $boutiqueData['logo'],
                    'cover_image' => $boutiqueData['cover_image'],
                    'ville' => $boutiqueData['ville'],
                    'quartier' => $boutiqueData['quartier'],
                    'taux_cashback' => $boutiqueData['taux_cashback'],
                    'livraison_gratuite' => $boutiqueData['livraison_gratuite'],
                    'note_moyenne' => $boutiqueData['note_moyenne'],
                    'nombre_avis' => $boutiqueData['nombre_avis'],
                    'certifie' => $boutiqueData['certifie'],
                    'statut' => 'actif',
                    'vues' => rand(100, 1000)
                ]
            );

            // Création des produits de la boutique
            foreach ($boutiqueData['produits'] as $produitData) {
                $categorie = Categorie::where('nom', $produitData['categorie'])->first();
                
                $produit = new Produit([
                    'nom' => $produitData['nom'],
                    'slug' => Str::slug($produitData['nom']),
                    'description' => $produitData['description'],
                    'prix' => $produitData['prix'],
                    'prix_compare' => $produitData['prix_compare'],
                    'image' => $produitData['image'],
                    'stock' => $produitData['stock'],
                    'promotion' => $produitData['promotion'],
                    'nouveau' => $produitData['nouveau'],
                    'meilleure_vente' => $produitData['meilleure_vente'],
                    'note_moyenne' => rand(35, 50) / 10, // Note entre 3.5 et 5.0
                    'nombre_avis' => rand(5, 150),
                    'statut' => 'actif'
                ]);

                $produit->boutique()->associate($boutique);
                if ($categorie) {
                    $produit->categorie()->associate($categorie);
                }
                $produit->save();
            }

            $createdBoutiques[] = $boutique->nom;
        }

        return response()->json([
            'message' => 'Boutiques et produits de démonstration créés avec succès',
            'boutiques' => $createdBoutiques
        ]);
    }
}
