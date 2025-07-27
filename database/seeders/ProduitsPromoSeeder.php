<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produit;
use Illuminate\Support\Facades\DB;

class ProduitsPromoSeeder extends Seeder
{
    /**
     * Exécute le seeder pour marquer des produits comme étant en promotion.
     */
    public function run(): void
    {
        // Vérifier s'il y a des produits dans la base de données
        if (Produit::count() > 0) {
            // Sélectionner aléatoirement 4 produits à mettre en promotion
            $produitsIds = Produit::inRandomOrder()
                ->take(4)
                ->pluck('id');
            
            // Mettre à jour ces produits pour les marquer comme étant en promotion
            Produit::whereIn('id', $produitsIds)
                ->update(['en_promotion' => true]);
                
            $this->command->info(count($produitsIds) . ' produits ont été marqués comme étant en promotion.');
        } else {
            $this->command->warn('Aucun produit trouvé dans la base de données. Veuillez d\'abord créer des produits.');
        }
    }
}
