<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Boutique;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PanierController extends Controller
{
    private function getCartKey(Boutique $boutique): string
    {
        // Panier isolé par boutique
        return 'carts.' . $boutique->slug;
    }

    private function recalc(array &$cart): void
    {
        $totalQty = 0; $totalAmount = 0;
        foreach ($cart['items'] as &$it) {
            $it['subtotal'] = $it['price'] * $it['qty'];
            $totalQty += $it['qty'];
            $totalAmount += $it['subtotal'];
        }
        $cart['total_qty']    = $totalQty;
        $cart['total_amount'] = $totalAmount;
    }

    public function add(Request $request, $boutiqueSlug)
    {
        $data = $request->validate([
            'product_id' => ['required','integer','exists:produits,id'],
            'qty'        => ['nullable','integer','min:1'],
        ]);

        $boutique = Boutique::where('slug', $boutiqueSlug)->firstOrFail();
        $key = $this->getCartKey($boutique);

        $produit = Produit::where('id', $data['product_id'])
            ->where('boutique_id', $boutique->id)
            ->firstOrFail();

        $addQty = $data['qty'] ?? 1;
        $stock  = (int) $produit->qty;              // <-- stock en BDD

        if ($stock <= 0) {
            return response()->json([
                'ok' => false,
                'message' => 'Rupture de stock.',
            ], 422);
        }

        // Panier actuel
        $cart = session($key, [
            'items' => [],
            'total_qty' => 0,
            'total_amount' => 0,
        ]);

        $currentQty = $cart['items'][$produit->id]['qty'] ?? 0;
        $maxAddable = max(0, $stock - $currentQty);

        if ($maxAddable <= 0) {
            return response()->json([
                'ok' => false,
                'message' => 'Stock maximum déjà atteint pour cet article.',
            ], 422);
        }

        // Quantité réellement ajoutée (clamp si nécessaire)
        $toAdd = min($addQty, $maxAddable);

        if (isset($cart['items'][$produit->id])) {
            $cart['items'][$produit->id]['qty'] += $toAdd;
        } else {
            $cart['items'][$produit->id] = [
                'id'       => $produit->id,
                'name'     => $produit->nomproduit,
                'slug'     => $produit->slug,
                'image'    => $produit->image,
                'price'    => (int) $produit->prix,
                'qty'      => $toAdd,
                'subtotal' => 0,
                'stock'    => $stock,             // <-- on garde aussi le stock côté session
            ];
        }

        $this->recalc($cart);
        session([$key => $cart]);

        $limited = $toAdd < $addQty;

        return response()->json([
            'ok'     => true,
            'count'  => $cart['total_qty'],
            'amount' => $cart['total_amount'],
            'flash'  => $limited
                ? "Stock limité : ajout de {$toAdd} (max atteint)."
                : "{$produit->nomproduit} ajouté au panier.",
            'limited'=> $limited,
            'max'    => $stock,
            'itemQty'=> $cart['items'][$produit->id]['qty'],
        ]);
    }


    public function count($boutiqueSlug)
    {
        $boutique = Boutique::where('slug', $boutiqueSlug)->firstOrFail();
        $key = $this->getCartKey($boutique);
        return response()->json([
            'count' => session("$key.total_qty", 0)
        ]);
    }

    public function updateQty(Request $request, $boutiqueSlug, $productId)
    {
        $request->validate(['qty' => ['required','integer','min:0']]);

        $boutique = Boutique::where('slug', $boutiqueSlug)->firstOrFail();
        $key = $this->getCartKey($boutique);
        $cart = session($key, null);

        if (!$cart || !isset($cart['items'][$productId])) {
            return response()->json(['ok'=>false,'message'=>'Article introuvable'], 404);
        }

        // Récupérer le stock actuel en BDD (sécurité)
        $produit = Produit::where('id', $productId)
            ->where('boutique_id', $boutique->id)
            ->first();
        if (!$produit) return response()->json(['ok'=>false,'message'=>'Produit introuvable'], 404);

        $stock = (int) $produit->qty;
        $qty = (int) $request->qty;

        if ($qty <= 0) {
            unset($cart['items'][$productId]);
            $this->recalc($cart);
            session([$key => $cart]);

            return response()->json([
                'ok'   => true,
                'cart' => [
                    'total_qty'    => $cart['total_qty'],
                    'total_amount' => $cart['total_amount'],
                    'is_empty'     => empty($cart['items']),
                ],
                'item'   => null,
                'flash'  => 'Article retiré du panier',
            ]);
        }

        // Clamp au stock
        $limited = false;
        if ($qty > $stock) {
            $qty = $stock;
            $limited = true;
        }

        $cart['items'][$productId]['qty']   = $qty;
        $cart['items'][$productId]['stock'] = $stock;

        $this->recalc($cart);
        session([$key => $cart]);

        return response()->json([
            'ok'   => true,
            'cart' => [
                'total_qty'    => $cart['total_qty'],
                'total_amount' => $cart['total_amount'],
                'is_empty'     => empty($cart['items']),
            ],
            'item' => [
                'id'       => $productId,
                'qty'      => $qty,
                'subtotal' => $cart['items'][$productId]['subtotal'],
                'max'      => $stock,
            ],
            'flash'   => $limited ? "Stock max atteint: {$stock}." : 'Quantité mise à jour',
            'limited' => $limited,
        ]);
    }


    public function remove($boutiqueSlug, $productId)
    {
        $boutique = Boutique::where('slug', $boutiqueSlug)->firstOrFail();
        $key = $this->getCartKey($boutique);
        $cart = session($key, null);

        if ($cart && isset($cart['items'][$productId])) {
            unset($cart['items'][$productId]);
            $this->recalc($cart);
            session([$key => $cart]);
        }

        return response()->json([
            'ok'   => true,
            'cart' => [
                'total_qty'    => $cart['total_qty'] ?? 0,
                'total_amount' => $cart['total_amount'] ?? 0,
                'is_empty'     => empty($cart['items'] ?? []),
            ],
            'flash' => 'Article supprimé',
        ]);
    }

    public function lepanier($boutiqueSlug)
    {
        $boutique = Boutique::where('slug', $boutiqueSlug)->firstOrFail();
        $key = $this->getCartKey($boutique);
        $cart = session($key, ['items'=>[], 'total_qty'=>0, 'total_amount'=>0]);

        // Sécuriser les items existants (ajouter/mettre à jour le stock)
        if (!empty($cart['items'])) {
            $ids = array_keys($cart['items']);
            $stocks = Produit::where('boutique_id', $boutique->id)
                ->whereIn('id', $ids)
                ->pluck('qty', 'id');
            foreach ($cart['items'] as $id => &$it) {
                $it['stock'] = (int) ($stocks[$id] ?? 0);
                // si la qté en panier > stock actuel, la clamp
                if ($it['qty'] > $it['stock']) {
                    $it['qty'] = $it['stock'];
                }
            }
            $this->recalc($cart);
            session([$key => $cart]);
        }

        return view('frontend.boutique.panier.lepanier', [
            'boutique' => $boutique,
            'cart'     => $cart,
        ]);
    }

    public function checkoutShow($boutiqueSlug)
    {
        $boutique = Boutique::where('slug', $boutiqueSlug)->firstOrFail();
        $key = $this->getCartKey($boutique);
        $cart = session($key, ['items'=>[], 'total_qty'=>0, 'total_amount'=>0]);

        if (empty($cart['items'])) {
            return redirect()->route('lepanier', $boutiqueSlug)->with('error', 'Votre panier est vide.');
        }

        return view('frontend.boutique.paiement.caisse', compact('boutique','cart'));
    }

    public function checkoutStore(Request $request, $boutiqueSlug)
    {
        $request->validate([
            'numeroduclient'    => ['nullable'],
            'adresseduclient'   => ['nullable','string','max:255'],
            'channel'           => ['nullable','in:,CARD,OMCIV2,MOMO,FLOOZ,WAVE'], // "" = choix sur portail
            'use_cashback'      => ['nullable','integer','min:0'],
        ]);

        $boutique = Boutique::where('slug', $boutiqueSlug)->firstOrFail();
        $key = $this->getCartKey($boutique);
        $cart = session($key);

        if (!$cart || empty($cart['items'])) {
            return redirect()->route('lepanier', $boutiqueSlug)->with('error', 'Panier vide.');
        }

        // Récupère les produits pour sécuriser prix/stock + calculer le sous-total
        $ids = array_keys($cart['items']);
        $produits = Produit::where('boutique_id', $boutique->id)
            ->whereIn('id', $ids)->get()->keyBy('id');

        // --- NEW: calcule le sous-total "réel" et le max cashback utilisable
        $subtotal = 0;
        foreach ($cart['items'] as $id => $it) {
            if (!isset($produits[$id])) continue;
            $p = $produits[$id];
            $qty = min((int)$it['qty'], (int)$p->qty);
            if ($qty <= 0) continue;
            $subtotal += $qty * (int)$p->prix;
        }

        $walletBalance = optional(auth()->user()->wallet)->balance_fcfa ?? 0;
        $redeemMaxPercent = (float) env('CASHBACK_REDEEM_MAX_PERCENT', 0.5); // 50% par défaut
        $maxRedeemByPercent = (int) floor($subtotal * $redeemMaxPercent);
        $maxRedeem = min($walletBalance, $maxRedeemByPercent);

        $use = (int) $request->input('use_cashback', 0);
        $use = max(0, min($use, $maxRedeem)); // clamp

        // --- Création des commandes
        $commandeIds = [];

        DB::transaction(function () use ($cart, $produits, $boutique, &$commandeIds) {
            foreach ($cart['items'] as $id => $it) {
                if (!isset($produits[$id])) continue;
                $p = $produits[$id];

                $qty = min((int)$it['qty'], (int)$p->qty);
                if ($qty <= 0) continue;

                $price = (int) $p->prix;
                $total = $qty * $price;

                $cashback = method_exists($boutique, 'computeCashback')
                    ? $boutique->computeCashback($total)
                    : 0;

                $commande = Commande::create([
                    'boutique_id'      => $boutique->id,
                    'user_id'          => auth()->id(),
                    'produit_id'       => $p->id,
                    'qty'              => $qty,
                    'price_fcfa'       => $price,
                    'total_fcfa'       => $total,
                    'status'           => 'pending',
                    'payment_provider' => 'paiementpro',
                    'cashback_fcfa'    => $cashback,
                    // si tu as ajouté ces colonnes côté DB, tu peux déjà stocker:
                    // 'client_phone'   => $request->input('numeroduclient'),
                    // 'client_address' => $request->input('adresseduclient'),
                ]);

                $commandeIds[] = $commande->id;
            }
        });

        if (empty($commandeIds)) {
            return redirect()->route('lepanier', $boutiqueSlug)
                ->with('error', "Aucune commande créée (stock insuffisant ?).");
        }

        // --- NEW: répartir l'utilisation de cashback voulue sur chaque commande
        if ($use > 0) {
            $totalAll = Commande::whereIn('id', $commandeIds)->sum('total_fcfa');
            $remaining = $use;

            foreach ($commandeIds as $id) {
                $c = Commande::find($id);
                $part = (int) floor($use * ($c->total_fcfa / max(1, $totalAll)));
                if ($part > $remaining) $part = $remaining;

                // nécessite la colonne `wallet_to_debit_fcfa` dans `commandes`
                $c->wallet_to_debit_fcfa = $part;
                $c->save();

                $remaining -= $part;
            }
        }

        // Vider le panier de cette boutique
        session()->forget($key);

        // 👉 Une seule commande : on part direct chez le PSP
        if (count($commandeIds) === 1) {
            $commande = Commande::find($commandeIds[0]);
            $request->merge(['channel' => $request->input('channel')]);
            return app(\App\Http\Controllers\PaiementProController::class)->init(
                $request,
                $commande,
                app(\App\Services\PaiementProService::class)
            );
        }

        // Sinon, page liste + message
        return redirect()->route('listecommandeclients', $boutique->slug)
            ->with('success', count($commandeIds).' commande(s) créée(s). Choisissez une commande à payer.');
    }
}
