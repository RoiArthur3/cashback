@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Vérification de l'authentification pour afficher la section héro -->
    @auth
    <!-- Hero Section -->
    <div class="hero-section mx-3 mb-4 p-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ Auth::user()->profile_picture ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=ffffff&color=1e40af' }}" alt="Photo de profil" class="rounded-circle me-3" width="60" height="60">
                    <div>
                        <h2 class="fw-bold mb-0">Bonjour, {{ Auth::user()->name }} !</h2>
                        <p class="mb-0 text-white-50">Découvrez les meilleures offres du moment</p>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <div class="stat-card px-4 py-3 rounded-4" style="background: rgba(255,255,255,0.1);">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi bi-coin fs-1 text-warning"></i>
                            </div>
                            <div>
                                <p class="mb-0 small text-white-50">Solde Cashback</p>
                                <h4 class="mb-0 fw-bold">{{ number_format(rand(50, 500), 2, ',', ' ') }} €</h4>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card px-4 py-3 rounded-4" style="background: rgba(255,255,255,0.1);">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi bi-gift fs-1 text-success"></i>
                            </div>
                            <div>
                                <p class="mb-0 small text-white-50">Commandes en cours</p>
                                <h4 class="mb-0 fw-bold">{{ rand(1, 10) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card px-4 py-3 rounded-4" style="background: rgba(255,255,255,0.1);">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi bi-star-fill fs-1 text-info"></i>
                            </div>
                            <div>
                                <p class="mb-0 small text-white-50">Fidélité</p>
                                <h4 class="mb-0 fw-bold">Niveau {{ ['Bronze', 'Argent', 'Or', 'Platine'][rand(0, 3)] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="p-4">
                    <h5 class="mb-3 fw-bold text-white">Mon QR Code</h5>
                    <div class="mb-3">
                        <!-- Génération du QR Code avec l'ID utilisateur -->
                        <div class="d-inline-block p-3 bg-white rounded-3">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode('user:' . Auth::id()) }}" alt="QR Code" class="img-fluid">
                        </div>
                    </div>
                    <p class="small text-white-50 mb-0">Montrez ce code en caisse pour cumuler vos points de fidélité</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Le reste du contenu de la page d'accueil -->
    @include('buyer.partials.content')
</div>
@endsection
