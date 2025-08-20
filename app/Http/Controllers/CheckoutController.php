<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Commande;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function list($boutiqueSlug)
    {
        $boutique = Boutique::where('slug',$boutiqueSlug)->firstOrFail();
        $commandes = Commande::with('produit')
            ->where('boutique_id', $boutique->id)
            ->where('user_id', auth()->id())
            ->where('status','pending')
            ->latest()->get();

        return view('frontend.checkout.list', compact('boutique','commandes'));
    }
}
