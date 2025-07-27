<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Vérifie si l'utilisateur a l'un des rôles demandés
        $hasRole = false;
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                $hasRole = true;
                break;
            }
        }

        if (!$hasRole) {
            // Redirection en fonction du rôle de l'utilisateur
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('vendeur')) {
                return redirect()->route('vendeur.dashboard');
            } elseif ($user->hasRole('annonceur')) {
                return redirect()->route('annonceur.dashboard');
            } else {
                return redirect()->route('accueil')->with('error', 'Accès non autorisé.');
            }
        }

        return $next($request);
    }
}
