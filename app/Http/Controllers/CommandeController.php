<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Services\PaiementProService;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function orderscommercant(Request $request)
    {
        $ownerId = $request->user()->id;
        $boutiqueIds = Boutique::where('user_id', $ownerId)->pluck('id');

        if ($boutiqueIds->isEmpty()) {
            return view('commercial.orders', [
                'orders' => collect(), 'paidSum'=>0, 'pendingSum'=>0, 'countPaid'=>0, 'countPending'=>0,
                'boutiques'=>collect(), 'boutiqueId'=>null
            ]);
        }

        $boutiqueId = $request->integer('boutique_id');
        $filterIds  = $boutiqueId ? collect([$boutiqueId]) : $boutiqueIds;

        $q = Commande::with([
                'user:id,name,email',
                'produit:id,nomproduit,prix',
                'boutique:id,nommagasin',
            ])
            ->whereIn('boutique_id', $filterIds);

        $orders = $q->orderByDesc('created_at')->paginate(30)->withQueryString();

        $paidSum     = (clone $q)->where('status','paid')->sum('total_fcfa');
        $pendingSum  = (clone $q)->where('status','pending')->sum('total_fcfa');
        $countPaid   = (clone $q)->where('status','paid')->count();
        $countPending= (clone $q)->where('status','pending')->count();

        $boutiques = Boutique::whereIn('id', $boutiqueIds)->orderBy('nommagasin')->get(['id','nommagasin']);

        return view('admin.commandes.comcommercant', compact(
            'orders','paidSum','pendingSum','countPaid','countPending','boutiques','boutiqueId'
        ));
     //
    }

    public function clientorders(Request $request)
    {
        $uid = $request->user()->id;

        $q = Commande::with([
                'boutique:id,nommagasin,slug',
                'produit:id,nomproduit,slug,prix'
            ])
            ->where('user_id', $uid);

        $orders = $q->orderByDesc('created_at')->paginate(15)->withQueryString();

        $paidSum     = (clone $q)->where('status','paid')->sum('total_fcfa');
        $pendingSum  = (clone $q)->where('status','pending')->sum('total_fcfa');
        $countPaid   = (clone $q)->where('status','paid')->count();
        $countPending= (clone $q)->where('status','pending')->count();

        return view('admin.commandes.mescommandes', compact(
            'orders','paidSum','pendingSum','countPaid','countPending'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Commande $commande)
    {
        abort_unless($commande->user_id === $request->user()->id, 403);
        $commande->load(['boutique:id,nommagasin,slug','produit:id,nomproduit,slug,prix']);
        return view('admin.commandes.lacommandeclient', compact('commande'));
    }

    public function pay(Request $request, Commande $commande, PaiementProService $psp)
    {
        abort_unless($commande->user_id === $request->user()->id, 403);
        // channel optionnel: "" = choix sur le portail
        $request->validate([
            'channel' => ['nullable','in:,CARD,OMCIV2,MOMO,FLOOZ,WAVE']
        ]);

        // réutilise ton flux existant
        return app(\App\Http\Controllers\PaiementProController::class)->init($request, $commande, $psp);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commande $commande)
    {
        //
    }
}
