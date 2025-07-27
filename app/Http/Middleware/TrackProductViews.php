<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class TrackProductViews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Vérifier si c'est une requête pour afficher un produit
        if ($request->route() && $request->route()->getName() === 'produits.show') {
            $produitId = $request->route('produit');
            
            // Vérifier si l'utilisateur a déjà vu ce produit dans cette session
            $viewedProducts = Session::get('viewed_products', []);
            
            if (!in_array($produitId, $viewedProducts)) {
                // Ajouter le produit à la liste des produits vus
                $viewedProducts[] = $produitId;
                Session::put('viewed_products', $viewedProducts);
                
                // Incrémenter le compteur de vues
                Produit::where('id', $produitId)->increment('vues');
            }
        }

        return $response;
    }
}
