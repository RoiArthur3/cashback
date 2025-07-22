<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AnnonceurController extends Controller
{
    public function index()
    {
        return view('annonceur.dashboard');
    }
    // Ajoutez ici les actions spécifiques à l'annonceur (gestion des campagnes, statistiques, etc.)
}
