<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        return view('client.dashboard');
    }

    // Ajoutez ici les actions spécifiques au client

    public function achats()
    {
        $achats = \App\Models\Achat::with(['boutique', 'produit'])->where('user_id', Auth::id())->latest()->get();
        return view('client.achats', compact('achats'));
    }
}
