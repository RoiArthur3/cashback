<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Services\Cart\Facades\Cart;

class CartController extends Controller
{
    /**
     * Afficher le contenu du panier
     */
    public function index()
    {
        $cartItems = Cart::content();
        $total = Cart::total();
        $count = Cart::count();
        
        return view('cart.index', compact('cartItems', 'total', 'count'));
    }

    /**
     * Ajouter un produit au panier
     */
    public function store(Request $request)
    {
        $produit = Produit::findOrFail($request->produit_id);
        
        Cart::add(
            $produit->id,
            $produit->nom,
            $produit->prix,
            $request->quantite ?? 1,
            [
                'image' => $produit->image,
                'boutique_id' => $produit->boutique_id,
                'slug' => $produit->slug
            ]
        );
        
        return redirect()->route('cart.index')
            ->with('success', 'Produit ajouté au panier avec succès');
    }

    /**
     * Mettre à jour la quantité d'un produit dans le panier
     */
    public function update(Request $request, $rowId)
    {
        $qty = $request->qty;
        
        // Valider la quantité
        $request->validate([
            'qty' => 'required|numeric|min:1'
        ]);
        
        Cart::update($rowId, $qty);
        
        return redirect()->route('cart.index')
            ->with('success', 'Panier mis à jour avec succès');
    }

    /**
     * Supprimer un produit du panier
     */
    public function destroy($rowId)
    {
        Cart::remove($rowId);
        
        return redirect()->route('cart.index')
            ->with('success', 'Produit retiré du panier');
    }
    
    /**
     * Vider le panier
     */
    public function empty()
    {
        Cart::destroy();
        
        return redirect()->route('cart.index')
            ->with('success', 'Votre panier a été vidé');
    }
}
