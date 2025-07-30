<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Parrainage;

class ParrainageController extends Controller
{
    // Affiche la page principale du programme de parrainage
    public function index()
    {
        $user = Auth::user();
        $filleuls = $user->filleuls()->with('achats')->get();
        $gains = $filleuls->sum(function($filleul) {
            return $filleul->achats->sum('cashback');
        });
        return view('parrainage.index', compact('filleuls', 'gains'));
    }

    // Affiche l'historique des filleuls
    public function historique()
    {
        $user = Auth::user();
        $filleuls = $user->filleuls()->with('achats')->get();
        return view('parrainage.filleuls', compact('filleuls'));
    }

    // Affiche les gains cumulés
    public function gains()
    {
        $user = Auth::user();
        $filleuls = $user->filleuls()->with('achats')->get();
        $gains = $filleuls->sum(function($filleul) {
            return $filleul->achats->sum('cashback');
        });
        return view('parrainage.gains', compact('gains'));
    }
}
