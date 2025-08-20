<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Models\CashbackCredit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\PaiementProService;

class PaiementProController extends Controller
{
    public function init(Request $request, Commande $commande, PaiementProService $pp)
    {

        if (!auth()->check() || ($commande->user_id && $commande->user_id !== auth()->id())) {
            abort(403, 'Vous ne pouvez payer que vos propres commandes.');
        }

                Log::info('pp.init BEFORE INITIATE', ['commande_id' => $commande->id]);

    
        if ($commande->status !== 'pending') {
            return back()->with('error', 'Commande déjà traitée.');
        }



        // (Re)chargement produit & totals
        /* $produit = $commande->produit()->firstOrFail();
        if ($commande->qty > $produit->qty) {
            return back()->with('error', 'Stock insuffisant.');
        } */

        // Prépare la requête initTransact (doc "OnlinePayment v2") :contentReference[oaicite:8]{index=8}
        $payload = [
            'merchantId'          => env('PAIEMENTPRO_MERCHANT_ID'),
            'countryCurrencyCode' => env('PAIEMENTPRO_CURRENCY_CODE', '952'),
            'amount'              => $commande->total_fcfa,
            'referenceNumber'     => 'CMD-'.$commande->id,
            'channel'             => $request->input('channel',''),
            'customerId'          => $commande->user_id ?: 0,
            'customerEmail'       => optional($request->user())->email,
            'customerFirstName'   => optional($request->user())->name ?? 'Client',
            'customerPhoneNumber' => optional($request->user())->numero,
            'description'         => 'Achat '.$commande->produit->nomproduit,
            'notificationURL'     => route('pp.notify'),
            'returnURL'           => route('pp.return'),
            'returnContext'       => http_build_query(['commande_id' => $commande->id]),
        ];

        try {
            $redirectUrl = $pp->initiate($payload);
            // redirige l'utilisateur vers la page de paiement Paiement Pro :contentReference[oaicite:9]{index=9}
            return redirect()->away($redirectUrl);
        } catch (\Throwable $e) {
            Log::error('pp.init ERROR', ['err' => $e->getMessage()]);
            return back()->with('error', $e->getMessage());
        }
    }

    // Retour navigateur (l’utilisateur revient après paiement)
    public function return(Request $request)
    {
        // Ils renvoient sur returnURL + returnContext; le statut final sûr vient plutôt de la notification serveur à serveur. :contentReference[oaicite:10]{index=10}
        return redirect()->back()->with('success', 'Paiement en cours de confirmation…');
    }

    // Notification (serveur à serveur)
    public function notify(Request $request)
    {
        // La doc indique qu’ils POSTent : merchantId, amount, referenceNumber, transactiondt, customerId, returnContext, responsecode, hashcode… :contentReference[oaicite:11]{index=11}

        $data = $request->all();

        // 1) Vérifier hashcode (implémente la même formule que dans makeHashcode)
        // TODO: vérifier le hash exact selon la spec contractuelle
        // if (!$this->verifyHash($data)) return response('BAD HASH', 400);

        // 2) Récupérer notre commande via referenceNumber OU returnContext
        parse_str($data['returnContext'] ?? '', $ctx);
        $commandeId = (int)($ctx['commande_id'] ?? 0);
        $commande = Commande::with('boutique','produit')->find($commandeId);
        if (!$commande) return response('COMMANDE NOT FOUND', 404);

        // 3) Vérifier le code retour : 0 = succès, -1 = échec :contentReference[oaicite:12]{index=12}
        $responseCode = (string)($data['responsecode'] ?? '-1');
        if ($responseCode !== '0') {
            $commande->status = 'failed';
            $commande->save();
            return response('KO', 200);
        }

        // 4) Marquer payée + décrémenter stock + créditer cashback
        if ($commande->status !== 'paid') {
            DB::transaction(function () use ($commande) {
                // payé
                $commande->status  = 'paid';
                $commande->paid_at = now();
                $commande->save();

                // stock
                Produit::where('id', $commande->produit_id)
                    ->decrement('qty', $commande->qty);

                // cashback
                if ($commande->cashback_fcfa > 0 && $commande->user_id) {
                    CashbackCredit::create([
                        'user_id'     => $commande->user_id,
                        'boutique_id' => $commande->boutique_id,
                        'commande_id' => $commande->id,
                        'amount_fcfa' => $commande->cashback_fcfa,
                    ]);
                    $commande->cashback_credited_at = now();
                    $commande->save();
                }
            });
        }

        return response('OK', 200);
    }
}
