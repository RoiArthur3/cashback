<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Models\Produit;
use App\Models\User;
use App\Models\Commande;
use App\Models\Cashback;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Afficher le tableau de bord d'administration
     */
    public function dashboard()
    {
        // Récupérer les statistiques de base
        $stats = [
            'users' => User::count(),
            'boutiques' => Boutique::count(),
            'produits' => Produit::count(),
            'commandes' => Commande::count(),
            'ventes' => Commande::sum('montant_total'),
            'cashback_valides' => Cashback::where('statut', 'validé')->sum('montant'),
            'cashback_attente' => Cashback::where('statut', 'en_attente')->count(),
            'montant_reverser' => Boutique::sum('solde'),
            'litiges' => 0, // À implémenter avec le module de litiges
            'retraits' => 0, // À implémenter avec le module de retraits
            'ventes_suspectes' => 0, // À implémenter avec la détection de fraude
        ];

        // Récupérer les boutiques récentes avec le nombre de produits
        $recentBoutiques = Boutique::withCount('produits')
            ->latest()
            ->take(5)
            ->get();

        // Récupérer les produits récents avec leurs boutiques
        $recentProducts = Produit::with(['boutique', 'categorie'])
            ->withCount('commandes')
            ->latest()
            ->take(5)
            ->get();

        // Récupérer les statistiques mensuelles pour le graphique
        $monthlySales = $this->getMonthlySalesData();
        $monthlyUsers = $this->getMonthlyUsersData();

        return view('admin.dashboard', compact(
            'stats', 
            'recentBoutiques', 
            'recentProducts',
            'monthlySales',
            'monthlyUsers'
        ));
    }

    /**
     * Récupérer les données de ventes mensuelles pour le graphique
     */
    protected function getMonthlySalesData()
    {
        $sales = Commande::select(
                DB::raw('SUM(montant_total) as total'),
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'labels' => $sales->pluck('month'),
            'data' => $sales->pluck('total')
        ];
    }

    /**
     * Récupérer les données d'utilisateurs mensuels pour le graphique
     */
    protected function getMonthlyUsersData()
    {
        $users = User::select(
                DB::raw('COUNT(*) as count'),
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'labels' => $users->pluck('month'),
            'data' => $users->pluck('count')
        ];
    }
}
