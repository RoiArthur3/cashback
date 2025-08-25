<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Models\CashbackSplit;
use App\Models\CashbackCredit;
use App\Models\WalletTransaction;
use App\Services\CashbackService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
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
        $data = $request->all();
        Log::info('PP.notify HIT', $data);

        // 1) (Optionnel mais recommandé) Vérifier le hash de la notif
        // if (!$this->verifyHash($data)) { Log::warning('PP.notify BAD HASH'); return response('BAD HASH', 400); }

        // 2) Retrouver la commande via returnContext (prio) ou referenceNumber "CMD-15"
        parse_str($data['returnContext'] ?? '', $ctx);
        $commandeId = isset($ctx['commande_id']) ? (int)$ctx['commande_id'] : null;
        if (!$commandeId && !empty($data['referenceNumber'])) {
            $commandeId = (int) preg_replace('/\D/', '', (string) $data['referenceNumber']);
        }

        $commande = Commande::with(['boutique','produit','user'])->find($commandeId);
        if (!$commande) {
            Log::error('PP.notify commande introuvable', ['commande_id' => $commandeId]);
            return response('COMMANDE NOT FOUND', 404);
        }

        // 3) Code de retour du PSP : "0" = succès
        $responseCode = (string)($data['responsecode'] ?? '-1');
        if ($responseCode !== '0') {
            $commande->update(['status' => 'failed']);
            Log::warning('PP.notify KO', ['commande_id' => $commande->id, 'code' => $responseCode]);
            return response('KO', 200);
        }

        // 4) Idempotence : si déjà payé ET cashback déjà crédité, on sort
        if ($commande->status === 'paid' && $commande->cashback_credited_at) {
            return response('OK', 200);
        }

        // (Optionnel) Vérifier le montant pour sécurité
        $amount = (int)($data['amount'] ?? 0);
        if ($amount > 0 && $amount !== (int)$commande->total_fcfa) {
            Log::warning('PP.notify amount mismatch', [
                'commande_id' => $commande->id,
                'notif_amount' => $amount,
                'order_total'  => (int)$commande->total_fcfa
            ]);
            // Tu peux décider d’accepter quand même, ou de refuser.
        }

        // 5) Finaliser : payé + stock + cashback (répartition + wallets)
        $this->finalizePaidCommande($commande);

        return response('OK', 200);
    }

    /**
     * (Optionnel) Vérifie la signature/hash de la notification.
     * Remplace la formule par celle fournie par ton PSP (même que pour init).
     */

    private function verifyHash(array $data): bool
    {
        $merchantId = env('PAIEMENTPRO_MERCHANT_ID');
        $secret     = env('PAIEMENTPRO_SECRET');

        // ⚠️ EXEMPLE : adapte exactement à ta fiche PSP
        $base = $merchantId
            .($data['referenceNumber'] ?? '')
            .($data['amount'] ?? '')
            .(($data['countryCurrencyCode'] ?? $data['currency'] ?? ''))
            .$secret;

        $expected = hash('sha256', $base);
        $received = strtolower((string)($data['hashcode'] ?? ''));
        return $received && hash_equals(strtolower($expected), $received);
    }

    /**
     * Marque la commande payée, décrémente le stock,
     * répartit le cashback et crédite les wallets (buyer/commercial/parrain).
     * Idempotent côté crédits (idempotency_key).
     */
    private function finalizePaidCommande(Commande $commande): void
    {
        DB::transaction(function () use ($commande) {
            // 1) Marquer payée
            if ($commande->status !== 'paid') {
                $commande->status  = 'paid';
                $commande->paid_at = now();
                $commande->save();
            }

            // 2) Décrémenter le stock (verrou si tu veux)
            if ($commande->relationLoaded('produit') || $commande->produit) {
                $prod = $commande->produit()->lockForUpdate()->first() ?: $commande->produit;
                $newQty = max(0, (int)$prod->qty - (int)$commande->qty);
                $prod->update(['qty' => $newQty]);
            }

            // 3) Répartition du cashback brut
            $splits = CashbackService::split($commande); // ['buyer','commercial','parrain','cbm']

            $buyerId      = (int) $commande->user_id ?: null;
            $commercialId = (int) optional($commande->boutique)->user_id ?: null;
            $parrainId    = (int) optional($commande->user)->parrain_id ?: null;

             Log::info('PP.finalize IDs', [
                'commande_id' => $commande->id,
                'buyerId'     => $buyerId,
                'commercialId'=> $commercialId,
                'parrainId'   => $parrainId,
            ]);

            // Helper de crédit idempotent
            $credit = function (?int $userId, int $amount, string $role, string $desc) use ($commande) {
                if (!$userId || $amount <= 0) return;
                $wallet = Wallet::firstOrCreate(['user_id' => $userId], ['balance_fcfa' => 0]);

                $key = "CBK:{$commande->id}:{$role}:U{$userId}";
                if (WalletTransaction::where('idempotency_key', $key)->exists()) return;

                $wallet->increment('balance_fcfa', $amount);
                WalletTransaction::create([
                    'wallet_id'       => $wallet->id,
                    'commande_id'     => $commande->id,
                    'type'            => 'credit',
                    'source'          => 'cashback',
                    'amount_fcfa'     => $amount,
                    'description'     => $desc,
                    'idempotency_key' => $key,
                ]);
            };

            // Acheteur
            if (($splits['client'] ?? 0) > 0 && $commande->user_id) {
                $credit((int)$commande->user_id, (int)$splits['client'], 'client', "Cashback acheteur commande {$commande->id}");
                CashbackSplit::create([
                    'commande_id' => $commande->id,
                    'role'        => 'client',
                    'user_id'     => (int)$commande->user_id, // ✅ direct depuis la commande
                    'amount_fcfa' => $splits['client'],
                ]);
            }

            // Commercial
            if (($splits['commercial'] ?? 0) > 0 && optional($commande->boutique)->user_id) {
                $credit((int)$commande->boutique->user_id, (int)$splits['commercial'], 'commercial', "Prime commercial commande {$commande->id}");
                CashbackSplit::create([
                    'commande_id' => $commande->id,
                    'role'        => 'commercial',
                    'user_id'     => (int)$commande->boutique->user_id,
                    'amount_fcfa' => $splits['commercial'],
                ]);
            }

            // Parrain (si présent)
            if (($splits['parrain'] ?? 0) > 0 && optional($commande->user)->parrain_id) {
                $credit((int)$commande->user->parrain_id, (int)$splits['parrain'], 'parrain', "Prime parrain commande {$commande->id}");
                CashbackSplit::create([
                    'commande_id' => $commande->id,
                    'role'        => 'parrain',
                    'user_id'     => (int)$commande->user->parrain_id,
                    'amount_fcfa' => $splits['parrain'],
                ]);
            }

            // Part CBM — juste pour audit (sans wallet si tu n’en as pas pour CBM)
            if (($splits['cbm'] ?? 0) > 0) {
                CashbackSplit::create([
                    'commande_id' => $commande->id,
                    'role'        => 'cbm',
                    'user_id'     => null,
                    'amount_fcfa' => (int)$splits['cbm'],
                ]);
            }

            // 4) Flag anti double-crédit
            $commande->cashback_credited_at = now();
            $commande->save();
        });
    }

    public function devForceFinalize(Commande $commande)
    {
        // Sécurité : seulement en local
        abort_unless(App::environment('local'), 403, 'Forbidden');
        $this->finalizePaidCommande($commande); // <-- appelle la méthode privée
        return response('OK', 200);
    }
}
