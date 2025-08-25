<?php
namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Cashback;
use Illuminate\Http\Request;
use App\Models\CashbackSplit;
use App\Models\WalletTransaction;

class CashbackController extends Controller
{
    public function transactions(Request $request)
    {
        $boutiqueId = $request->integer('boutique_id'); // null si non fourni

        // Query principale : transactions de cashback (crédits)
        $q = WalletTransaction::with([
                'wallet.user:id,name,email',
                'commande' => fn($cq) => $cq->select('id','boutique_id')->with('boutique:id,nommagasin'),
            ])
            ->where('source','cashback')
            ->where('type','credit');

        if ($boutiqueId) {
            $q->whereHas('commande', fn($cq) => $cq->where('boutique_id', $boutiqueId));
        }

        $tx = $q->orderByDesc('created_at')->paginate(50)->withQueryString();

        // Total payé (selon filtre)
        $totalCashbackPaye = (clone $q)->sum('amount_fcfa');

        // Répartition globale par rôle (selon filtre)
        $byRoleQ = CashbackSplit::query();
        if ($boutiqueId) {
            $byRoleQ->whereHas('commande', fn($cq) => $cq->where('boutique_id', $boutiqueId));
        }
        $byRole = $byRoleQ->selectRaw('role, SUM(amount_fcfa) as total')
            ->groupBy('role')
            ->pluck('total','role')
            ->toArray();

        // Pour le sélecteur de boutiques + libellé courant
        $boutiques = Boutique::orderBy('nommagasin')->get(['id','nommagasin']);
        $currentBoutique = $boutiqueId ? $boutiques->firstWhere('id', $boutiqueId) : null;

        return view('admin.cashback.transactionadmin', compact(
            'tx','totalCashbackPaye','byRole','boutiques','boutiqueId','currentBoutique'
        ));
    }

    public function transactionscommercant(Request $request)
    {
        $ownerId = $request->user()->id;

        // toutes les boutiques du commerçant (gère le cas multi-boutiques)
        $boutiqueIds = Boutique::where('user_id', $ownerId)->pluck('id');
        if ($boutiqueIds->isEmpty()) {
            return view('commercial.transactions', [
                'tx' => collect(), 'sum' => 0, 'byRole' => [], 'boutiques' => collect(), 'boutiqueId' => null
            ]);
        }

        // filtre optionnel par boutique précise
        $boutiqueId = $request->integer('boutique_id');
        $filterIds  = $boutiqueId ? collect([$boutiqueId]) : $boutiqueIds;

        // transactions de cashback (crédits), rattachées à des commandes de SES boutiques
        $q = WalletTransaction::with([
                'wallet.user:id,name,email',
                'commande' => fn($cq) => $cq->select('id','boutique_id','user_id')
                                            ->with('boutique:id,nommagasin','user:id,name'),
            ])
            ->where('source','cashback')
            ->where('type','credit')
            ->whereHas('commande', fn($cq) => $cq->whereIn('boutique_id', $filterIds));

        $tx  = $q->orderByDesc('created_at')->paginate(30)->withQueryString();
        $sum = (clone $q)->sum('amount_fcfa');

        // répartition (client/commercial/parrain/cbm) pour SES boutiques
        $byRole = CashbackSplit::whereHas('commande', fn($cq) => $cq->whereIn('boutique_id', $filterIds))
            ->selectRaw('role, SUM(amount_fcfa) as total')
            ->groupBy('role')
            ->pluck('total','role')
            ->toArray();

        // pour le select
        $boutiques = Boutique::whereIn('id', $boutiqueIds)->orderBy('nommagasin')->get(['id','nommagasin']);

        return view('admin.cashback.transactioncommercant', compact('tx','sum','byRole','boutiques','boutiqueId'));
    }
}
