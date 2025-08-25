<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Boutique;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Models\CashbackSplit;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function dashboard()
    {
        $fuser = new User();

        $nbrusers  = User::where('role_id','!=',1)->count();
        $nbmagasin = Boutique::count();
        $nbproduit = $fuser->nbproduitbymagasin();
        $nbcategorie = $fuser->nbcategoriebymagasin();
        $nbcouponblackfriday = $fuser->nbcouponblackfriday();

        $wallet = auth()->user()->wallet()->with('transactions')->first();

        $roleId = auth()->user()->role_id;
        $uid    = auth()->id();

        // Sommes personnelles par rôle (client/parrain/commercial)
        $mine = CashbackSplit::where('user_id', $uid)
            ->selectRaw('role, COALESCE(SUM(amount_fcfa),0) as total')
            ->groupBy('role')
            ->pluck('total','role')->all();

        $myClient     = (int)($mine['client']     ?? 0);
        $myParrain    = (int)($mine['parrain']    ?? 0);
        $myCommercial = (int)($mine['commercial'] ?? 0);
        $myTotal      = $myClient + $myParrain + $myCommercial;

        // Total CBM global (uniquement utile pour l’admin)
        $cbmTotal = (int) CashbackSplit::where('role','cbm')->sum('amount_fcfa');

        return view('admin.dashboard', compact(
            'nbrusers','nbmagasin','nbproduit','nbcategorie','nbcouponblackfriday','wallet',
            'roleId','cbmTotal','myClient','myParrain','myCommercial','myTotal'
        ));
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
