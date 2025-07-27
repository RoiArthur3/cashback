@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Header utilisateur --}}
    <div class="row mb-4">
        <div class="col-12 d-flex flex-column flex-md-row align-items-center justify-content-between bg-white rounded shadow-sm p-4">
            <div class="d-flex align-items-center mb-3 mb-md-0">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2563eb&color=fff&size=80" class="rounded-circle shadow" width="80" height="80" alt="Avatar">
                <div class="ms-4">
                    <h3 class="fw-bold mb-0 text-danger">Bienvenue, {{ $user->name }} !</h3>
                    <div class="text-muted"><i class="bi bi-person-badge"></i> {{ ucfirst($role) }}</div>
                    <div class="text-muted small"><i class="bi bi-envelope"></i> {{ $user->email }}</div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('logout') }}" class="btn btn-outline-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    {{-- Statistiques clés --}}
    <div class="row g-3 mb-4">
        @if($role === 'acheteur')
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-primary mb-2"><i class="bi bi-basket fs-1"></i></div>
                        <h4 class="fw-bold text-primary">{{ $user->achats->count() }}</h4>
                        <div class="text-muted">Achats effectués</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-success mb-2"><i class="bi bi-cash-coin fs-1"></i></div>
                        <h4 class="fw-bold text-success">{{ number_format($user->achats->sum('cashback') ?? 0, 0, ',', ' ') }}</h4>
                        <div class="text-muted">FCFA de cashback</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-warning mb-2"><i class="bi bi-star fs-1"></i></div>
                        <h4 class="fw-bold text-warning">{{ $user->avis->count() }}</h4>
                        <div class="text-muted">Avis déposés</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-info mb-2"><i class="bi bi-heart fs-1"></i></div>
                        <h4 class="fw-bold text-info">0</h4>
                        <div class="text-muted">Favoris</div>
                    </div>
                </div>
            </div>
        @elseif($role === 'admin')
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-primary mb-2"><i class="bi bi-people fs-1"></i></div>
                        <h4 class="fw-bold text-primary">{{ \App\Models\User::count() }}</h4>
                        <div class="text-muted">Utilisateurs</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-info mb-2"><i class="bi bi-shop fs-1"></i></div>
                        <h4 class="fw-bold text-info">{{ \App\Models\Boutique::count() }}</h4>
                        <div class="text-muted">Boutiques</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-success mb-2"><i class="bi bi-box-seam fs-1"></i></div>
                        <h4 class="fw-bold text-success">{{ \App\Models\Produit::count() }}</h4>
                        <div class="text-muted">Produits</div>
                    </div>
                </div>
            </div>
        @elseif($role === 'commercant')
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-info mb-2"><i class="bi bi-shop fs-1"></i></div>
                        <h4 class="fw-bold text-info">{{ $user->boutiques->count() }}</h4>
                        <div class="text-muted">Boutiques</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-success mb-2"><i class="bi bi-box-seam fs-1"></i></div>
                        <h4 class="fw-bold text-success">{{ $user->boutiques->sum(function($boutique) { return $boutique->produits->count(); }) }}</h4>
                        <div class="text-muted">Produits</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-primary mb-2"><i class="bi bi-currency-exchange fs-1"></i></div>
                        <h4 class="fw-bold text-primary">{{ $user->boutiques->sum(function($boutique) { return $boutique->achats->count(); }) }}</h4>
                        <div class="text-muted">Ventes</div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Actions rapides --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-lightning"></i> Actions rapides</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        @if($role === 'acheteur')
                            <a href="{{ route('buyer.index') }}" class="btn btn-primary"><i class="bi bi-house"></i> Accueil acheteur</a>
                            <a href="{{ route('acheteur.profil') }}" class="btn btn-outline-secondary"><i class="bi bi-person"></i> Mon profil</a>
                            <a href="{{ route('acheteur.achats') }}" class="btn btn-outline-success"><i class="bi bi-basket"></i> Mes achats</a>
                            <a href="{{ route('acheteur.cagnotte') }}" class="btn btn-outline-warning"><i class="bi bi-cash-coin"></i> Ma cagnotte</a>
                        @elseif($role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-warning"><i class="bi bi-shield-lock"></i> Back-office</a>
                            <a href="{{ url('/users') }}" class="btn btn-outline-primary"><i class="bi bi-people"></i> Gérer les utilisateurs</a>
                            <a href="{{ url('/boutiques') }}" class="btn btn-outline-info"><i class="bi bi-shop"></i> Gérer les boutiques</a>
                        @elseif($role === 'commercant')
                            <a href="{{ url('/boutiques') }}" class="btn btn-primary"><i class="bi bi-shop"></i> Mes boutiques</a>
                            <a href="{{ url('/produits/create') }}" class="btn btn-success"><i class="bi bi-plus-circle"></i> Ajouter un produit</a>
                        @elseif($role === 'partenaire')
                            <a href="#" class="btn btn-info"><i class="bi bi-bar-chart"></i> Statistiques partenaires</a>
                        @elseif($role === 'annonceur')
                            <a href="#" class="btn btn-warning"><i class="bi bi-megaphone"></i> Mes annonces</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sections dynamiques --}}
    @if($role === 'acheteur')
        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Dernières commandes</h5>
                    </div>
                    <div class="card-body">
                        @if($user->achats->count() > 0)
                            @foreach($user->achats->sortByDesc('created_at')->take(5) as $achat)
                                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                    <div>
                                        <strong>{{ $achat->produit->nom ?? 'Produit supprimé' }}</strong><br>
                                        <small class="text-muted">{{ $achat->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold">{{ number_format($achat->montant, 0, ',', ' ') }} FCFA</div>
                                        <small class="text-success">+{{ number_format($achat->cashback, 0, ',', ' ') }} FCFA cashback</small>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-basket fs-1 mb-3"></i><br>
                                Aucun achat pour le moment
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-bell"></i> Notifications</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Bienvenue sur votre espace personnel !
                        </div>
                        <div class="alert alert-success">
                            <i class="bi bi-gift"></i> Profitez de nos offres spéciales
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif($role === 'admin')
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-graph-up"></i> Statistiques générales</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="text-primary">{{ \App\Models\Achat::count() }}</h4>
                                    <div class="text-muted">Achats totaux</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="text-success">{{ number_format(\App\Models\Achat::sum('montant'), 0, ',', ' ') }}</h4>
                                    <div class="text-muted">FCFA de CA</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="text-warning">{{ number_format(\App\Models\Achat::sum('cashback'), 0, ',', ' ') }}</h4>
                                    <div class="text-muted">FCFA de cashback</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-info">{{ \App\Models\Avis::count() }}</h4>
                                <div class="text-muted">Avis déposés</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
