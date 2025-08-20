<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Boutique;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $fuser = new User();

        $nbrusers = User::where('role_id','!=',1)->count();

        $nbmagasin = Boutique::count();

        $nbproduit = $fuser->nbproduitbymagasin();

        $nbcategorie = $fuser->nbcategoriebymagasin();

        $nbcouponblackfriday = $fuser->nbcouponblackfriday();

        return view('admin.dashboard',compact('nbrusers', 'nbmagasin','nbproduit','nbcategorie','nbcouponblackfriday'));
    }

    public function listecommandeclients($boutiqueSlug)
    {
        $boutique = Boutique::where('slug',$boutiqueSlug)->firstOrFail();
        $commandes = Commande::with('produit')
            ->where('boutique_id', $boutique->id)
            ->where('user_id', auth()->id())
            ->where('status','pending')
            ->latest()->get();

        return view('admin.commandes.mescommandes', compact('boutique','commandes'));
    }
}
