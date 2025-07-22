<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
    // Liste des utilisateurs
    public function users()
    {
        $users = \App\Models\User::all();
        return view('admin.users', compact('users'));
    }

    // Liste des boutiques
    public function boutiques()
    {
        $boutiques = \App\Models\Boutique::all();
        return view('admin.boutiques', compact('boutiques'));
    }

    // Liste des cashbacks
    public function cashbacks()
    {
        $cashbacks = \App\Models\Cashback::with('boutique')->get()->map(function($cb) {
            return (object) [
                'boutique' => $cb->boutique->nom ?? '',
                'taux' => $cb->taux,
                'offre' => $cb->offre,
            ];
        });
        return view('admin.cashbacks', compact('cashbacks'));
    }
}
