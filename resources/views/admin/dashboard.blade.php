@extends('admin.layouts.app')

@section('header', 'Tableau de bord')

@section('content')
<div class="grid grid-cols-1 gap-5 mt-6 sm:grid-cols-2 lg:grid-cols-4">
    <!-- Carte Utilisateurs -->
    <div class="p-5 bg-white rounded-lg shadow">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500 truncate">Utilisateurs</div>
                <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['users'] ?? '0' }}</div>
            </div>
            <div class="p-3 bg-indigo-100 rounded-full">
                <i class="text-indigo-600 fas fa-users text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                Voir tous les utilisateurs
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </div>

    <!-- Carte Boutiques -->
    <div class="p-5 bg-white rounded-lg shadow">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500 truncate">Boutiques</div>
                <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['boutiques'] ?? '0' }}</div>
            </div>
            <div class="p-3 bg-green-100 rounded-full">
                <i class="text-green-600 fas fa-store text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.boutiques.index') }}" class="text-sm font-medium text-green-600 hover:text-green-500">
                Gérer les boutiques
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </div>

    <!-- Carte Produits -->
    <div class="p-5 bg-white rounded-lg shadow">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500 truncate">Produits</div>
                <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['produits'] ?? '0' }}</div>
            </div>
            <div class="p-3 bg-yellow-100 rounded-full">
                <i class="text-yellow-600 fas fa-boxes text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.produits.index') }}" class="text-sm font-medium text-yellow-600 hover:text-yellow-500">
                Gérer les produits
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </div>

    <!-- Carte Commandes -->
    <div class="p-5 bg-white rounded-lg shadow">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500 truncate">Commandes</div>
                <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['ventes'] ?? '0' }}</div>
            </div>
            <div class="p-3 bg-red-100 rounded-full">
                <i class="text-red-600 fas fa-shopping-cart text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <a href="#" class="text-sm font-medium text-red-600 hover:text-red-500">
                Voir les commandes
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </div>
</div>
<!-- Dernières boutiques ajoutées -->
<div class="mt-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-medium text-gray-900">Dernières boutiques ajoutées</h2>
        <a href="{{ route('admin.boutiques.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
            Voir tout
        </a>
    </div>
    
    <div class="overflow-hidden bg-white shadow sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @forelse($recentBoutiques as $boutique)
                <li>
                    <a href="{{ route('admin.boutiques.edit', $boutique) }}" class="block hover:bg-gray-50">
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    @if($boutique->logo)
                                        <img class="w-10 h-10 rounded-full" src="{{ Storage::url($boutique->logo) }}" alt="Logo de {{ $boutique->nom }}">
                                    @else
                                        <div class="flex items-center justify-center w-10 h-10 text-white bg-indigo-500 rounded-full">
                                            {{ strtoupper(substr($boutique->nom, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-indigo-600 truncate">{{ $boutique->nom }}</p>
                                        <p class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-map-marker-alt mr-1.5"></i>
                                            {{ $boutique->ville }}, {{ $boutique->quartier }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $boutique->produits_count ?? 0 }} produits
                                        </span>
                                        @if($boutique->certifie)
                                            <span class="inline-flex items-center px-2.5 py-0.5 ml-2 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i> Certifié
                                            </span>
                                        @endif
                                    </div>
                                    <div class="mt-1 text-sm text-gray-500">
                                        Ajoutée le {{ $boutique->created_at->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            @empty
                <li class="px-4 py-6 text-center text-gray-500">
                    Aucune boutique n'a été trouvée.
                </li>
            @endforelse
        </ul>
    </div>
</div>
<!-- Derniers produits ajoutés -->
<div class="mt-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-medium text-gray-900">Derniers produits ajoutés</h2>
        <a href="{{ route('admin.produits.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
            Voir tout
        </a>
    </div>
    
    <div class="overflow-hidden bg-white shadow sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @forelse($recentProducts as $produit)
                <li>
                    <a href="{{ route('admin.produits.edit', $produit) }}" class="block hover:bg-gray-50">
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    @if($produit->image)
                                        <img class="w-16 h-16 rounded-md" src="{{ Storage::url($produit->image) }}" alt="{{ $produit->nom }}">
                                    @else
                                        <div class="flex items-center justify-center w-16 h-16 text-gray-400 bg-gray-100 rounded-md">
                                            <i class="fas fa-image text-2xl"></i>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">{{ $produit->nom }}</p>
                                        <p class="text-sm text-gray-500">{{ $produit->boutique->nom ?? 'Aucune boutique' }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                                        @if($produit->en_promotion && $produit->prix_promotionnel)
                                            <span class="ml-2 text-sm font-medium text-red-600">
                                                {{ number_format($produit->prix_promotionnel, 0, ',', ' ') }} FCFA
                                            </span>
                                        @endif
                                    </div>
                                    <div class="mt-1">
                                        @if($produit->stock > 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                En stock ({{ $produit->stock }})
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Rupture de stock
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            @empty
                <li class="px-4 py-6 text-center text-gray-500">
                    Aucun produit n'a été trouvé.
                </li>
            @endforelse
        </ul>
    </div>
</div>

<!-- Statistiques financières -->
<div class="grid grid-cols-1 mt-8 gap-5 md:grid-cols-2 lg:grid-cols-4">
    <!-- Total des ventes -->
    <div class="p-6 bg-white rounded-lg shadow">
        <div class="flex items-center">
            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Total des ventes</p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ number_format($stats['ventes'] ?? 0, 0, ',', ' ') }} FCFA
                </p>
            </div>
        </div>
    </div>

    <!-- Cashback validés -->
    <div class="p-6 bg-white rounded-lg shadow">
        <div class="flex items-center">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Cashback validés</p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ number_format($stats['cashback_valides'] ?? 0, 0, ',', ' ') }} FCFA
                </p>
            </div>
        </div>
    </div>

    <!-- Cashback en attente -->
    <div class="p-6 bg-white rounded-lg shadow">
        <div class="flex items-center">
            <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Cashback en attente</p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $stats['cashback_attente'] ?? 0 }} demandes
                </p>
            </div>
        </div>
    </div>

    <!-- Montant à reverser -->
    <div class="p-6 bg-white rounded-lg shadow">
        <div class="flex items-center">
            <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">À reverser aux commerçants</p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ number_format($stats['montant_reverser'] ?? 0, 0, ',', ' ') }} FCFA
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Graphiques -->
<div class="grid grid-cols-1 mt-8 gap-5 lg:grid-cols-2">
    <!-- Graphique des ventes mensuelles -->
    <div class="p-6 bg-white rounded-lg shadow">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Ventes mensuelles</h3>
            <div class="flex space-x-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    12 derniers mois
                </span>
            </div>
        </div>
        <div class="h-80">
            <canvas id="monthlySalesChart"></canvas>
        </div>
    </div>
    
    <!-- Graphique des utilisateurs -->
    <div class="p-6 bg-white rounded-lg shadow">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Nouveaux utilisateurs</h3>
            <div class="flex space-x-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    12 derniers mois
                </span>
            </div>
        </div>
        <div class="h-80">
            <canvas id="monthlyUsersChart"></canvas>
        </div>
    </div>
</div>

<!-- Alertes et activités récentes -->
<div class="grid grid-cols-1 mt-8 gap-5 lg:grid-cols-2">
    <!-- Alertes importantes -->
    <div class="p-6 bg-white rounded-lg shadow">
        <h3 class="mb-4 text-lg font-medium text-gray-900">Alertes importantes</h3>
        <div class="space-y-4">
            @if(($stats['litiges'] ?? 0) > 0)
            <a href="#" class="flex items-start p-3 -mx-3 rounded-lg hover:bg-gray-50">
                <div class="flex-shrink-0 mt-1">
                    <span class="flex items-center justify-center w-8 h-8 text-white bg-red-500 rounded-full">
                        <i class="text-xs fas fa-exclamation-triangle"></i>
                    </span>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ $stats['litiges'] }} litige(s) ouvert(s)</p>
                    <p class="text-sm text-gray-500">À traiter dès que possible</p>
                </div>
            </a>
            @endif
            
            @if(($stats['cashback_attente'] ?? 0) > 0)
            <a href="#" class="flex items-start p-3 -mx-3 rounded-lg hover:bg-gray-50">
                <div class="flex-shrink-0 mt-1">
                    <span class="flex items-center justify-center w-8 h-8 text-white bg-yellow-500 rounded-full">
                        <i class="text-xs fas fa-clock"></i>
                    </span>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ $stats['cashback_attente'] }} demande(s) de cashback en attente</p>
                    <p class="text-sm text-gray-500">À valider ou rejeter</p>
                </div>
            </a>
            @endif
            
            @if(($stats['retraits'] ?? 0) > 0)
            <a href="#" class="flex items-start p-3 -mx-3 rounded-lg hover:bg-gray-50">
                <div class="flex-shrink-0 mt-1">
                    <span class="flex items-center justify-center w-8 h-8 text-white bg-blue-500 rounded-full">
                        <i class="text-xs fas fa-money-bill-wave"></i>
                    </span>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ $stats['retraits'] }} demande(s) de retrait</p>
                    <p class="text-sm text-gray-500">À traiter</p>
                </div>
            </a>
            @endif
            
            @if(($stats['ventes_suspectes'] ?? 0) > 0)
            <a href="#" class="flex items-start p-3 -mx-3 rounded-lg hover:bg-gray-50">
                <div class="flex-shrink-0 mt-1">
                    <span class="flex items-center justify-center w-8 h-8 text-white bg-purple-500 rounded-full">
                        <i class="text-xs fas fa-shield-alt"></i>
                    </span>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ $stats['ventes_suspectes'] }} activité(s) suspecte(s) détectée(s)</p>
                    <p class="text-sm text-gray-500">À examiner</p>
                </div>
            </a>
            @endif
            
            @if(($stats['litiges'] ?? 0) == 0 && ($stats['cashback_attente'] ?? 0) == 0 && ($stats['retraits'] ?? 0) == 0 && ($stats['ventes_suspectes'] ?? 0) == 0)
            <div class="flex items-center justify-center p-4 text-center text-gray-500 bg-gray-50 rounded-lg">
                <div>
                    <i class="text-4xl text-green-500 fas fa-check-circle"></i>
                    <p class="mt-2 font-medium">Aucune alerte pour le moment</p>
                    <p class="text-sm">Tout semble sous contrôle</p>
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Activité récente -->
    <div class="p-6 bg-white rounded-lg shadow">
        <h3 class="mb-4 text-lg font-medium text-gray-900">Activité récente</h3>
        <div class="space-y-4">
            @php
                $activities = [
                    [
                        'icon' => 'store',
                        'color' => 'indigo',
                        'title' => 'Nouvelle boutique en attente de validation',
                        'time' => 'Il y a 2 heures',
                        'count' => 3
                    ],
                    [
                        'icon' => 'shopping-bag',
                        'color' => 'green',
                        'title' => 'Nouvelle commande #' . rand(10000, 99999),
                        'time' => 'Il y a 5 heures',
                        'count' => 1
                    ],
                    [
                        'icon' => 'exclamation-triangle',
                        'color' => 'yellow',
                        'title' => 'Produit en rupture de stock',
                        'time' => 'Hier à 14:32',
                        'count' => 5
                    ],
                    [
                        'icon' => 'user-plus',
                        'color' => 'blue',
                        'title' => 'Nouvel utilisateur inscrit',
                        'time' => 'Hier à 09:15',
                        'count' => 1
                    ],
                    [
                        'icon' => 'tag',
                        'color' => 'purple',
                        'title' => 'Nouvelle catégorie ajoutée',
                        'time' => 'Avant-hier',
                        'count' => 2
                    ]
                ];
            @endphp
            
            @foreach($activities as $activity)
            <a href="#" class="flex items-start justify-between p-3 -mx-3 rounded-lg group hover:bg-gray-50">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <span class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-{{ $activity['color'] }}-500">
                            <i class="text-xs fas fa-{{ $activity['icon'] }}"></i>
                        </span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                        <p class="text-sm text-gray-500">{{ $activity['time'] }}</p>
                    </div>
                </div>
                @if($activity['count'] > 1)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $activity['color'] }}-100 text-{{ $activity['color'] }}-800">
                    {{ $activity['count'] }}
                </span>
                @endif
            </a>
            @endforeach
            
            <div class="pt-2 text-center">
                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    Voir toute l'activité
                </a>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
