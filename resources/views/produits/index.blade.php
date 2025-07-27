@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- En-tête de la page -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="fw-bold mb-3" style="color: var(--primary-blue);">Nos Produits</h1>
            <p class="text-muted">Découvrez notre sélection de produits avec cashback</p>
        </div>
    </div>

    <div class="row">
        <!-- Filtres latéraux -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">Filtres</h5>
                    
                    <!-- Filtre par catégorie -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Catégories</h6>
                        <div class="list-group list-group-flush">
                            @foreach($categories as $categorie)
                            <a href="#" class="list-group-item list-group-item-action border-0 px-0 py-2">
                                {{ $categorie->nom }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Autres filtres peuvent être ajoutés ici -->
                </div>
            </div>
        </div>

        <!-- Liste des produits -->
        <div class="col-lg-9">
            <!-- Barre de tri et résultats -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="text-muted">
                    {{ $produits->total() }} produits trouvés
                </div>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Trier par : Pertinence
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                        <li><a class="dropdown-item" href="#">Pertinence</a></li>
                        <li><a class="dropdown-item" href="#">Prix croissant</a></li>
                        <li><a class="dropdown-item" href="#">Prix décroissant</a></li>
                        <li><a class="dropdown-item" href="#">Meilleures ventes</a></li>
                        <li><a class="dropdown-item" href="#">Nouveautés</a></li>
                    </ul>
                </div>
            </div>

            <!-- Grille des produits -->
            <div class="row g-4">
                @forelse($produits as $produit)
                <div class="col-md-4 col-6">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden product-card">
                        <!-- Badge de réduction -->
                        @if($produit->reduction > 0)
                        <span class="position-absolute top-0 end-0 m-2 bg-danger text-white rounded-pill px-2 py-1 small">
                            -{{ $produit->reduction }}%
                        </span>
                        @endif
                        
                        <!-- Image du produit -->
                        <div class="position-relative" style="height: 200px; overflow: hidden;">
                            <img src="{{ $produit->image ?? 'https://via.placeholder.com/300x200' }}" 
                                 class="card-img-top h-100 w-100 object-fit-cover" 
                                 alt="{{ $produit->nom }}">
                        </div>
                        
                        <div class="card-body">
                            <!-- Catégorie -->
                            <div class="small text-muted mb-1">
                                {{ $produit->categorie->nom ?? 'Sans catégorie' }}
                            </div>
                            
                            <!-- Nom du produit -->
                            <h5 class="card-title mb-2">
                                <a href="{{ route('produits.show', $produit->id) }}" class="text-decoration-none text-dark">
                                    {{ Str::limit($produit->nom, 40) }}
                                </a>
                            </h5>
                            
                            <!-- Boutique -->
                            <p class="small text-muted mb-2">
                                Par <a href="#" class="text-decoration-none">{{ $produit->boutique->nom ?? 'Boutique inconnue' }}</a>
                            </p>
                            
                            <!-- Prix et Cashback -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    @if($produit->reduction > 0)
                                        <span class="text-decoration-line-through text-muted me-2 small">
                                            {{ number_format($produit->prix, 2, ',', ' ') }} €
                                        </span>
                                        <span class="fw-bold text-danger">
                                            {{ number_format($produit->prix * (1 - $produit->reduction/100), 2, ',', ' ') }} €
                                        </span>
                                    @else
                                        <span class="fw-bold">
                                            {{ number_format($produit->prix, 2, ',', ' ') }} €
                                        </span>
                                    @endif
                                </div>
                                
                                @if($produit->taux_cashback > 0)
                                <div class="bg-light-blue p-1 px-2 rounded-pill small">
                                    <i class="fas fa-coins text-warning me-1"></i>
                                    <span class="fw-bold">{{ $produit->taux_cashback }}%</span> cashback
                                </div>
                                @endif
                            </div>
                            
                            <!-- Bouton d'action -->
                            <div class="d-grid mt-3">
                                <a href="{{ $produit->lien_affiliation ?? '#' }}" 
                                   class="btn btn-primary rounded-pill" 
                                   target="_blank">
                                    Voir l'offre
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="display-1 text-muted">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h4 class="mt-3">Aucun produit disponible pour le moment</h4>
                    <p class="text-muted">Revenez plus tard pour découvrir nos offres</p>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($produits->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $produits->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .product-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .object-fit-cover {
        object-fit: cover;
    }
    :root {
        --primary-blue: #1e40af;
        --light-blue: #3b82f6;
        --lighter-blue: #60a5fa;
    }
    .bg-light-blue {
        background-color: #ebf5ff;
        color: var(--primary-blue);
    }
</style>
@endsection
