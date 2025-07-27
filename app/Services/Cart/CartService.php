<?php

namespace App\Services\Cart;

use Illuminate\Support\Facades\Session;

class CartService
{
    protected $sessionKey = 'shopping_cart';

    /**
     * Obtenir le contenu du panier
     */
    public function content()
    {
        return Session::get($this->sessionKey, []);
    }

    /**
     * Ajouter un article au panier
     */
    public function add($id, $name, $price, $quantity = 1, array $options = [])
    {
        $cart = $this->content();
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'options' => $options,
            ];
        }

        Session::put($this->sessionKey, $cart);
        
        return $cart;
    }

    /**
     * Mettre à jour la quantité d'un article
     */
    public function update($id, $quantity)
    {
        $cart = $this->content();
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            Session::put($this->sessionKey, $cart);
        }
        
        return $cart;
    }

    /**
     * Supprimer un article du panier
     */
    public function remove($id)
    {
        $cart = $this->content();
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put($this->sessionKey, $cart);
        }
        
        return $cart;
    }

    /**
     * Vider le panier
     */
    public function destroy()
    {
        Session::forget($this->sessionKey);
        return [];
    }

    /**
     * Obtenir le nombre total d'articles dans le panier
     */
    public function count()
    {
        return array_sum(array_column($this->content(), 'quantity'));
    }

    /**
     * Obtenir le montant total du panier
     */
    public function total()
    {
        $total = 0;
        
        foreach ($this->content() as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return $total;
    }
}
