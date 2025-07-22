@extends('layouts.app')

@section('content')
<div class="container my-4">
    <!-- 1. En-tête / Bannière -->
    <div class="card mb-4 shadow-sm rounded-4">
        <div class="row g-0 align-items-center">
            <div class="col-md-3 text-center p-3">
                <img src="{{ $boutique->logo }}" alt="Logo {{ $boutique->nom }}" style="width:90px;height:90px;object-fit:contain;border-radius:16px;">
            </div>
            <div class="col-md-6 p-3">
                <img src="{{ $boutique->couverture }}" alt="Couverture" class="w-100 rounded-3 mb-2" style="max-height:120px;object-fit:cover;">
                <h2 class="fw-bold mb-1">{{ $boutique->nom }}</h2>
                <span class="text-warning fw-semibold">{{ number_format($boutique->note,1) }} ★</span>
                <span class="text-muted ms-2">({{ $boutique->avis_count ?? 0 }} avis)</span>
                <span class="badge bg-success ms-2">{{ $boutique->cashback }}% cashback offert</span>
            </div>
            <div class="col-md-3 p-3 text-center">
                <span class="text-muted">{{ $boutique->followers ?? 0 }} followers</span>
                <button class="btn btn-outline-primary rounded-pill mt-2"><i class="bi bi-person-plus"></i> Ajouter à mes cercles</button>
            </div>
        </div>
    </div>
    <!-- 2. Onglets de navigation -->
    <ul class="nav nav-tabs mb-4" id="boutiqueTabs" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-accueil" type="button" role="tab">🏠 Accueil</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-produits" type="button" role="tab">🛒 Produits</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-avis" type="button" role="tab">💬 Avis clients</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-cashback" type="button" role="tab">💰 Cashback & conditions</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-promos" type="button" role="tab">⚡ Promotions</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-troc" type="button" role="tab">🔄 Troc & Enchères</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-galerie" type="button" role="tab">📸 Galerie</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-contact" type="button" role="tab">📞 Contacter</button></li>
    </ul>
    <div class="tab-content" id="boutiqueTabsContent">
        <!-- Accueil -->
        <div class="tab-pane fade show active" id="tab-accueil" role="tabpanel">
            <!-- 3. Description -->
            <div class="mb-3">
                <h5 class="fw-bold">À propos de la boutique</h5>
                <p>{{ $boutique->description }}</p>
                @if($boutique->adresse)
                    <div><i class="bi bi-geo-alt"></i> {{ $boutique->adresse }}</div>
                @endif
                @if($boutique->horaires)
                    <div><i class="bi bi-clock"></i> {{ $boutique->horaires }}</div>
                @endif
                @if($boutique->telephone)
                    <div><i class="bi bi-telephone"></i> {{ $boutique->telephone }}</div>
                @endif
                @if($boutique->whatsapp)
                    <div><i class="bi bi-whatsapp"></i> {{ $boutique->whatsapp }}</div>
                @endif
                @if($boutique->email)
                    <div><i class="bi bi-envelope"></i> {{ $boutique->email }}</div>
                @endif
                @if($boutique->socials)
                    <div class="mt-2">
                        @foreach($boutique->socials as $social)
                            <a href="{{ $social->url }}" class="me-2"><i class="bi bi-{{ $social->icon }}"></i></a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <!-- Produits -->
        <div class="tab-pane fade" id="tab-produits" role="tabpanel">
            <div class="mb-3">
                <h5 class="fw-bold">Produits en vente</h5>
                <!-- Filtres -->
                <form class="d-flex gap-2 mb-3">
                    <select class="form-select w-auto"><option>Catégorie</option></select>
                    <select class="form-select w-auto"><option>Prix</option></select>
                    <select class="form-select w-auto"><option>Réduction</option></select>
                    <select class="form-select w-auto"><option>Cashback élevé</option></select>
                </form>
                <div class="row g-3">
                    @foreach($boutique->produits as $produit)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ $produit->image }}" alt="{{ $produit->nom }}" class="card-img-top" style="height:140px;object-fit:cover;">
                            <div class="card-body">
                                <h6 class="card-title mb-1">{{ $produit->nom }}</h6>
                                <div class="mb-1"><span class="fw-bold">{{ number_format($produit->prix,0,' ',' ') }} FCFA</span></div>
                                <span class="badge bg-success">{{ $produit->cashback }}% cashback</span>
                            </div>
                            <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
                                <button class="btn btn-outline-primary btn-sm">Voir</button>
                                <button class="btn btn-outline-success btn-sm">Ajouter au panier</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Avis clients -->
        <div class="tab-pane fade" id="tab-avis" role="tabpanel">
            <h5 class="fw-bold">Avis clients</h5>
            <!-- À intégrer : liste des avis -->
        </div>
        <!-- Cashback & conditions -->
        <div class="tab-pane fade" id="tab-cashback" role="tabpanel">
            <h5 class="fw-bold">Cashback & conditions</h5>
            <div class="mb-2"><span class="badge bg-success fs-5">{{ $boutique->cashback }}% sur chaque produit</span></div>
            <div class="mb-2">Délai moyen de validation : <strong>{{ $boutique->delai_validation }}</strong></div>
            <div class="mb-2">Conditions : {{ $boutique->conditions }}</div>
        </div>
        <!-- Promotions -->
        <div class="tab-pane fade" id="tab-promos" role="tabpanel">
            <h5 class="fw-bold">Promotions & ventes flash</h5>
            @if($boutique->promo)
                <div class="alert alert-danger"><i class="bi bi-lightning"></i> {{ $boutique->promo }}</div>
            @endif
        </div>
        <!-- Troc & Enchères -->
        <div class="tab-pane fade" id="tab-troc" role="tabpanel">
            <h5 class="fw-bold">Troc & Enchères</h5>
            <!-- À intégrer : liste des trocs/enchères -->
        </div>
        <!-- Galerie -->
        <div class="tab-pane fade" id="tab-galerie" role="tabpanel">
            <h5 class="fw-bold">Galerie / Vitrine</h5>
            <!-- À intégrer : galerie d’images -->
        </div>
        <!-- Contacter -->
        <div class="tab-pane fade" id="tab-contact" role="tabpanel">
            <h5 class="fw-bold">Contacter le vendeur</h5>
            <form class="mb-3">
                <input type="text" class="form-control mb-2" placeholder="Votre nom">
                <input type="email" class="form-control mb-2" placeholder="Votre email">
                <textarea class="form-control mb-2" rows="3" placeholder="Votre message"></textarea>
                <button class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>
    <!-- Produits vedettes -->
    <div class="mb-4">
        <h5 class="fw-bold mb-2">Produits en vedette</h5>
        <div class="row g-3">
            @foreach($boutique->produits as $produit)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $produit->image }}" alt="{{ $produit->nom }}" class="card-img-top" style="height:140px;object-fit:cover;">
                    <div class="card-body">
                        <h6 class="card-title mb-1">{{ $produit->nom }}</h6>
                        <div class="mb-1"><span class="fw-bold">{{ number_format($produit->prix,0,' ',' ') }} FCFA</span></div>
                        <span class="badge bg-success">{{ $produit->cashback }}% cashback</span>
                    </div>
                    <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
                        <button class="btn btn-outline-primary btn-sm">Voir</button>
                        <button class="btn btn-outline-success btn-sm">Ajouter au panier</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Mon Cercle & Réseau social -->
    <div class="d-flex gap-2 mb-4">
        <button class="btn btn-outline-primary rounded-pill"><i class="bi bi-person-plus"></i> Ajouter à mes cercles</button>
        <button class="btn btn-outline-secondary rounded-pill"><i class="bi bi-share"></i> Partager cette boutique</button>
        <button class="btn btn-outline-success rounded-pill"><i class="bi bi-eye"></i> Suivre la boutique</button>
    </div>
</div>
@endsection