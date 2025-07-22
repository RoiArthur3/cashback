<?php
namespace App\Http\Controllers;

use App\Models\Boutique;
use Illuminate\Http\Request;

class BoutiqueTestController extends Controller
{
    public function createDemo()
    {
        $boutique = Boutique::create([
            'nom' => 'Boutique Démo',
            'description' => 'Une boutique de test',
            // Ajoutez d'autres champs requis selon votre migration
        ]);
        return 'ID de la boutique créée : ' . $boutique->id;
    }
}
