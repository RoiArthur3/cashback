@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <form class="d-flex" action="#" method="GET">
                <input class="form-control me-2" type="search" placeholder="Rechercher produit, boutique, bon plan..." aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Rechercher</button>
            </form>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-header bg-success text-white">Ma cagnotte cashback</div>
                <div class="card-body">
                    <h4 class="display-6">12 500 FCFA</h4>
                    <a href="{{ route('acheteur.cagnotte') }}" class="btn btn-outline-success">Voir le détail</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-header bg-primary text-white">Mes commandes</div>
                <div class="card-body">
                    <span class="badge bg-warning">2 en attente</span>
                    <span class="badge bg-success">5 validées</span>
                    <a href="{{ route('acheteur.achats') }}" class="btn btn-outline-primary mt-2">Voir mes commandes</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-header bg-info text-white">Mes cashback</div>
                <div class="card-body">
                    <span class="badge bg-warning">1 en attente</span>
                    <span class="badge bg-success">8 validés</span>
                    <a href="#" class="btn btn-outline-info mt-2">Voir mes cashback</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 g-4">
        <div class="col-md-6">
            @auth
                @if(Auth::user()->role == 'acheteur')
                    <a href="{{ route('account.dashboard') }}" class="btn btn-cbm btn-lg">
                        <i class="bi bi-person-badge"></i> Mon espace
                    </a>
                @endif
            @endauth
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">Messagerie commerçants</div>
                <div class="card-body">
                    <a href="#" class="btn btn-outline-secondary">Accéder à la messagerie</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">Historique achats / cashback reçus</div>
                <div class="card-body">
                    <a href="#" class="btn btn-outline-dark">Voir l'historique</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 g-4">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">Recommandations personnalisées</div>
                <div class="card-body">
                    <a href="#" class="btn btn-outline-warning">Voir mes recommandations</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">Proposer un troc / participer à un deal</div>
                <div class="card-body">
                    <a href="#" class="btn btn-outline-success">Accéder aux deals</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">Mes cercles & amis</div>
                <div class="card-body">
                    <a href="#" class="btn btn-outline-primary">Voir mes cercles</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-pink text-white">Listes de mariage</div>
                <div class="card-body">
                    <a href="#" class="btn btn-outline-pink">Créer / voir mes listes</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
