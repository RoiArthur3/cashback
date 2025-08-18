<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boutique;
use App\Models\Produit;

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

}
