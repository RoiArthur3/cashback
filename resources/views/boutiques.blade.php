@extends('layouts.app')
@section('content')
<div class="container my-4">
    <!-- Barre de recherche et switch grille/liste -->
    <div class="mb-4 d-flex flex-wrap align-items-center gap-2 justify-content-between">
        <form class="d-flex flex-wrap gap-2 flex-grow-1">
            <input type="search" class="form-control flex-grow-1" placeholder="🔍 Rechercher une boutique, une marque ou un secteur" aria-label="Rechercher">
            <select class="form-select w-auto">
                <option value="">Filtre rapide</option>
                <option value="cashback">Cashback élevé</option>
                <option value="nouveaute">Nouveauté</option>
                <option value="populaire">Populaires</option>
            </select>
            <button class="btn btn-primary" type="submit">Rechercher</button>
        </form>
        <div class="btn-group ms-2" role="group">
            <button class="btn btn-outline-primary active" title="Vue grille"><i class="bi bi-grid-3x3-gap"></i></button>
            <button class="btn btn-outline-primary" title="Vue liste"><i class="bi bi-list"></i></button>
        </div>
    </div>
    <!-- Filtres dynamiques -->
    <div class="mb-4">
        <div class="d-flex flex-row flex-nowrap overflow-auto gap-2 pb-2">
            <button class="btn btn-outline-secondary">🛒 Tous</button>
            <button class="btn btn-outline-secondary">🧥 Mode & Accessoires</button>
            <button class="btn btn-outline-secondary">🍗 Alimentation & Restaurants</button>
            <button class="btn btn-outline-secondary">📱 Téléphonie & Électronique</button>
            <button class="btn btn-outline-secondary">💇‍♂️ Beauté & Bien-être</button>
            <button class="btn btn-outline-secondary">🏠 Maison & Déco</button>
            <button class="btn btn-outline-secondary">🚕 Transports / Services</button>
            <button class="btn btn-outline-secondary">🎁 Bons plans</button>
            <button class="btn btn-outline-secondary">⚡ Cashback élevé</button>
        </div>
    </div>
    <!-- Bandeau promotionnel -->
    @if(isset($promos) && count($promos))
    <div class="mb-4">
        <div class="alert alert-warning d-flex align-items-center overflow-auto animate__animated animate__pulse animate__faster">
            <i class="bi bi-megaphone-fill fs-4 me-2"></i>
            <div class="d-flex flex-row gap-3">
                @foreach($promos as $promo)
                    <span class="fw-bold text-dark">{{ $promo }}</span>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    <!-- Favoris -->
    @if(isset($favoris) && count($favoris))
    <div class="mb-4">
        <h5 class="fw-bold">❤️ Mes boutiques favorites</h5>
        <div class="row g-3">
            @foreach($favoris as $fav)
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm animate__animated animate__fadeIn">
                    <img src="{{ $fav->logo }}" alt="{{ $fav->nom }}" class="card-img-top rounded-circle mx-auto mt-3" style="width:64px;height:64px;object-fit:cover;">
                    <div class="card-body">
                        <h6 class="card-title mb-1 d-flex align-items-center justify-content-between">
                            {{ $fav->nom }}
                            <button class="btn btn-link p-0 ms-2 text-danger" title="Retirer des favoris"><i class="bi bi-heart-fill"></i></button>
                        </h6>
                        <span class="badge bg-success mb-1">+{{ $fav->cashback }}% cashback</span>
                        <span class="text-warning">⭐ {{ number_format($fav->note,1) }}</span>
                        <span class="badge bg-secondary ms-2">{{ $fav->categorie }}</span>
                        @if($fav->badge)
                            <span class="badge bg-danger ms-2">{{ $fav->badge }}</span>
                        @endif
                    </div>
                    <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
                        <a href="{{ route('boutique.show', $fav->id) }}" class="btn btn-outline-primary btn-sm">Voir les offres</a>
                        <a href="#" class="btn btn-outline-success btn-sm">Acheter avec cashback</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    <!-- Liste des boutiques -->
    <div class="row g-3">
        @foreach($boutiques as $boutique)
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card h-100 shadow-sm animate__animated animate__fadeIn boutique-card position-relative" style="transition: box-shadow .2s;">
                <button class="btn btn-link position-absolute top-0 end-0 m-2 p-0 text-danger" title="Ajouter aux favoris"><i class="bi bi-heart"></i></button>
                <img src="{{ $boutique->logo }}" alt="{{ $boutique->nom }}" class="card-img-top rounded-circle mx-auto mt-3" style="width:64px;height:64px;object-fit:cover;">
                <div class="card-body">
                    <h6 class="card-title mb-1 d-flex align-items-center justify-content-between">
                        {{ $boutique->nom }}
                        @if($boutique->badge)
                            <span class="badge bg-danger ms-2">{{ $boutique->badge }}</span>
                        @endif
                    </h6>
                    <span class="badge bg-success mb-1">+{{ $boutique->cashback }}% cashback</span>
                    <span class="text-warning">⭐ {{ number_format($boutique->note,1) }}</span>
                    <span class="badge bg-secondary ms-2">{{ $boutique->categorie }}</span>
                </div>
                <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
                    <a href="{{ route('boutique.show', $boutique->id) }}" class="btn btn-outline-primary btn-sm">Voir les offres</a>
                    <a href="#" class="btn btn-outline-success btn-sm">Acheter avec cashback</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@include('partials.footer')
<style>
.boutique-card:hover {
    box-shadow: 0 4px 24px rgba(34,34,59,0.15) !important;
    transform: translateY(-2px) scale(1.02);
    z-index: 2;
}
</style>
@endsection
