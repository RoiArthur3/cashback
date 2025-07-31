@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3 mb-3">
            @include('account.sidebar')
        </div>
        <div class="col-md-9">
            {{-- Message de bienvenue --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-person-circle fs-1"></i>
                        </div>
                        <div>
                            <h3 class="mb-1">👋 Bienvenue, {{ auth()->user()->name }} !</h3>
                            <p class="mb-0 opacity-75">Voici votre tableau de bord personnalisé</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ma cagnotte cashback --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">💰 Ma cagnotte cashback</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card bg-success text-white h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-wallet2 fs-1 mb-2"></i>
                                    <h4>{{ number_format(auth()->user()->achats->sum('cashback_montant') ?? 0, 0, ',', ' ') }} FCFA</h4>
                                    <div>Solde total</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-white h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-clock-history fs-1 mb-2"></i>
                                    <h4>{{ number_format(auth()->user()->achats->where('statut_cashback', 'en_attente')->sum('cashback_montant') ?? 0, 0, ',', ' ') }} FCFA</h4>
                                    <div>Cashback en attente</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex flex-column align-items-center justify-content-center">
                            <a href="{{ route('account.liste_mariage') }}" class="btn btn-outline-pink mb-3 px-4 py-2" style="font-weight:600; font-size:1.1rem; background:#fbbf24; color:#22223b; border:none;">
                                <i class="bi bi-heart-fill me-2"></i> Liste de mariage
                            </a>
                            <div class="mb-2">
                                <img src="{{ asset('images/qr-code.png') }}" alt="QR Code" width="80" height="80">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-primary text-white h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-check-circle fs-1 mb-2"></i>
                                    <h4>{{ number_format(auth()->user()->achats->where('statut_cashback', 'valide')->sum('cashback_montant') ?? Auth::user()->achats->sum('cashback_montant') ?? 0, 0, ',', ' ') }} FCFA</h4>
                                    <div>Cashback validé</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- Mes dernières commandes --}}
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">🛒 Mes dernières commandes</h5>
                        </div>
                        <div class="card-body">
                            @if(auth()->user()->achats->count() > 0)
                                @foreach(auth()->user()->achats->sortByDesc('created_at')->take(5) as $achat)
                                    <div class="card mb-2">
                                        <div class="card-body py-2">
                                            <div class="row align-items-center">
                                                <div class="col-md-2">
                                                    <img src="{{ $achat->produit->image ?? 'https://via.placeholder.com/50x50?text=P' }}" class="img-fluid rounded" width="50" alt="Produit">
                                                </div>
                                                <div class="col-md-5">
                                                    <h6 class="mb-1">{{ $achat->produit->nom ?? 'Produit supprimé' }}</h6>
                                                    <small class="text-muted">
                                                        <i class="bi bi-calendar"></i> {{ $achat->created_at->format('d/m/Y à H:i') }}
                                                    </small>
                                                </div>
                                                <div class="col-md-3 text-center">
                                                    <div class="fw-bold">{{ number_format($achat->montant, 0, ',', ' ') }} FCFA</div>
                                                    @if($achat->cashback_montant > 0)
                                                        <small class="text-success">+{{ number_format($achat->cashback_montant, 0, ',', ' ') }} FCFA</small>
                                                    @endif
                                                </div>
                                                <div class="col-md-2 text-center">
                                                    <span class="badge bg-success">Livré</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="text-center mt-3">
                                    <a href="{{ route('account.orders') }}" class="btn btn-outline-primary">Voir toutes mes commandes</a>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-bag fs-1 text-muted mb-3"></i>
                                    <h6 class="text-muted">Aucune commande pour le moment</h6>
                                    <a href="{{ route('boutiques.index') }}" class="btn btn-primary">Découvrir les produits</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Cashback du mois + Notifications --}}
                <div class="col-md-4">
                    {{-- Cashback obtenu ce mois-ci --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">🎁 Cashback ce mois-ci</h6>
                        </div>
                        <div class="card-body text-center">
                            <i class="bi bi-gift fs-1 text-success mb-2"></i>
                            <h4 class="text-success">{{ number_format(auth()->user()->achats->where('created_at', '>=', now()->startOfMonth())->sum('cashback_montant') ?? 0, 0, ',', ' ') }} FCFA</h4>
                            <p class="text-muted mb-0">Depuis le {{ now()->startOfMonth()->format('d/m/Y') }}</p>
                        </div>
                    </div>

                </div>

                {{-- Notifications et Messages --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="bi bi-bell-fill text-warning"></i> Notifications et Messages</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    {{-- Notifications importantes --}}
                                    <div class="col-md-8">
                                        <h6 class="mb-3"><i class="bi bi-bell text-warning"></i> Notifications importantes</h6>

                                        {{-- Cashback validé --}}
                                        <div class="notification-item d-flex align-items-center p-3 mb-2 bg-success bg-opacity-10 border-start border-success border-4 rounded">
                                            <div class="notification-icon me-3">
                                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 text-success">Cashback validé</h6>
                                                <p class="mb-0 text-muted small">Votre cashback de 2,500 FCFA a été crédité sur votre compte</p>
                                            </div>
                                            <div class="notification-time">
                                                <small class="text-muted">Il y a 2h</small>
                                            </div>
                                        </div>

                                        {{-- Commande expédiée --}}
                                        <div class="notification-item d-flex align-items-center p-3 mb-2 bg-info bg-opacity-10 border-start border-info border-4 rounded">
                                            <div class="notification-icon me-3">
                                                <i class="bi bi-truck text-info fs-5"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 text-info">Commande expédiée</h6>
                                                <p class="mb-0 text-muted small">Boutique Tech a expédié votre commande #12345</p>
                                            </div>
                                            <div class="notification-time">
                                                <small class="text-muted">Il y a 5h</small>
                                            </div>
                                        </div>

                                        {{-- Vente flash --}}
                                        <div class="notification-item d-flex align-items-center p-3 mb-2 bg-warning bg-opacity-10 border-start border-warning border-4 rounded">
                                            <div class="notification-icon me-3">
                                                <i class="bi bi-lightning-fill text-warning fs-5"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 text-warning">Vente flash en cours</h6>
                                                <p class="mb-0 text-muted small">-50% sur les smartphones jusqu'à minuit</p>
                                            </div>
                                            <div class="notification-time">
                                                <small class="text-muted">Il y a 1h</small>
                                            </div>
                                        </div>

                                        {{-- Nouvelle fonctionnalité --}}
                                        <div class="notification-item d-flex align-items-center p-3 mb-0 bg-secondary bg-opacity-10 border-start border-secondary border-4 rounded">
                                            <div class="notification-icon me-3">
                                                <i class="bi bi-gift-fill text-secondary fs-5"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 text-secondary">Nouvelle fonctionnalité</h6>
                                                <p class="mb-0 text-muted small">Découvrez les listes de mariage et le système de troc</p>
                                            </div>
                                            <div class="notification-time">
                                                <small class="text-muted">Hier</small>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Messages récents --}}
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0"><i class="bi bi-chat-dots text-primary"></i> Messages récents</h6>
                                            <a href="{{ route('account.messages') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                                        </div>

                                        <div class="list-group list-group-flush">
                                            <div class="list-group-item d-flex align-items-center border-0 px-0">
                                                <img src="https://ui-avatars.com/api/?name=Boutique+Tech&background=2563eb&color=fff"
                                                     class="rounded-circle me-3" width="40" height="40" alt="Avatar">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between">
                                                        <h6 class="mb-1">Boutique Tech</h6>
                                                        <small class="text-muted">10:30</small>
                                                    </div>
                                                    <p class="mb-1 text-muted small">Votre commande est prête pour expédition</p>
                                                </div>
                                                <span class="badge bg-danger">2</span>
                                            </div>
                                            <div class="list-group-item d-flex align-items-center border-0 px-0">
                                                <img src="https://ui-avatars.com/api/?name=Cercle+Famille&background=28a745&color=fff"
                                                     class="rounded-circle me-3" width="40" height="40" alt="Avatar">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between">
                                                        <h6 class="mb-1">Cercle Famille</h6>
                                                        <small class="text-muted">Hier</small>
                                                    </div>
                                                    <p class="mb-1 text-muted small">Marie: Qui veut participer à l'achat groupé ?</p>
                                                </div>
                                                <span class="badge bg-danger">1</span>
                                            </div>
                                            <div class="list-group-item d-flex align-items-center border-0 px-0">
                                                <img src="https://ui-avatars.com/api/?name=Support+CBM&background=ffc107&color=000"
                                                     class="rounded-circle me-3" width="40" height="40" alt="Avatar">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between">
                                                        <h6 class="mb-1">Support CBM</h6>
                                                        <small class="text-muted">2j</small>
                                                    </div>
                                                    <p class="mb-1 text-muted small">Merci pour votre retour...</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                {{-- Activités récentes --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="bi bi-activity text-success"></i> Activités récentes</h6>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <div class="timeline-item d-flex align-items-center mb-3">
                                        <div class="timeline-icon bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                            <i class="bi bi-check text-white small"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-1 small">Commande #12345 livrée</p>
                                            <small class="text-muted">Il y a 2h</small>
                                        </div>
                                    </div>
                                    <div class="timeline-item d-flex align-items-center mb-3">
                                        <div class="timeline-icon bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                            <i class="bi bi-cart text-white small"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-1 small">Nouvel achat effectué</p>
                                            <small class="text-muted">Il y a 1j</small>
                                        </div>
                                    </div>
                                    <div class="timeline-item d-flex align-items-center mb-3">
                                        <div class="timeline-icon bg-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                            <i class="bi bi-heart text-white small"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-1 small">Liste de mariage créée</p>
                                            <small class="text-muted">Il y a 2j</small>
                                        </div>
                                    </div>
                                    <div class="timeline-item d-flex align-items-center">
                                        <div class="timeline-icon bg-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                            <i class="bi bi-people text-white small"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-1 small">Rejoint le cercle "Famille"</p>
                                            <small class="text-muted">Il y a 3j</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
