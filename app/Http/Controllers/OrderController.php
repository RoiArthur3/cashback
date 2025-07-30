<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Récupère les commandes de l'utilisateur connecté
        $orders = auth()->user()->orders()->latest()->get();

        return view('orders.index', compact('orders'));
    }
}
