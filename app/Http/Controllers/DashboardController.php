<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Tableaux de bord disponibles par rôle
     *
     * @var array
     */
    protected $dashboards = [
        'admin' => [
            'route' => 'admin.dashboard',
            'roles' => ['admin', 'superadmin']
        ],
        'commercant' => [
            'route' => 'commercant.dashboard',
            'roles' => ['commercant', 'vendeur', 'boutique']
        ],
        'annonceur' => [
            'route' => 'annonceur.dashboard',
            'roles' => ['annonceur', 'advertiser']
        ],
        'acheteur' => [
            'route' => 'accueil',
            'roles' => ['acheteur', 'user', 'membre']
        ]
    ];

    /**
     * Afficher le tableau de bord en fonction du rôle de l'utilisateur
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Vérifier chaque tableau de bord configuré
        foreach ($this->dashboards as $dashboard) {
            foreach ($dashboard['roles'] as $role) {
                if ($user->hasRole($role)) {
                    try {
                        return redirect()->route($dashboard['route']);
                    } catch (\Exception $e) {
                        // En cas d'erreur de route, logger et continuer
                        Log::error("Erreur de redirection vers le tableau de bord: " . $e->getMessage());
                        continue;
                    }
                }
            }
        }

        // Si aucun rôle correspondant n'est trouvé, rediriger vers la page d'accueil
        return redirect()->route('accueil');
    }
}
