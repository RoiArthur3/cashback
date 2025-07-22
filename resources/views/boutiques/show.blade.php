@extends('layouts.app')
@section('content')
<div class="container py-4">
    @auth
        @if(Auth::id() === $boutique->user_id || Auth::user()->hasRole('admin'))
            <div class="mb-3 text-end">
                <a href="{{ route('boutiques.edit', $boutique->id) }}" class="btn btn-cbm"><i class="bi bi-pencil-square me-1"></i> Modifier ma boutique</a>
            </div>
        @endif
    @endauth
    <!-- Bandeau d’introduction dynamique selon le modèle choisi -->
    @php
        $modele = $boutique->modele ?? 'classique';
        $logo = $boutique->logo ? asset('storage/' . $boutique->logo) : null;
        $slides = $boutique->slide_images ? json_decode($boutique->slide_images, true) : [];
        $theme = $boutique->theme ?? 'default';
        $layout = $boutique->layout ?? 'standard';
    @endphp

    @if($modele === 'business')
    <div class="card mb-4 border-primary shadow-lg animate__animated animate__fadeIn">
        <div class="row g-0 align-items-center">
            <div class="col-md-3 text-center p-3">
                @if($logo)
                    <img src="{{ $logo }}" class="img-fluid rounded-circle border border-3 border-primary" style="max-width:120px;max-height:120px;object-fit:cover;" alt="Logo boutique">
                @else
                    <img src="https://via.placeholder.com/120x120?text=Logo" class="img-fluid rounded-circle border border-3 border-secondary" alt="Logo boutique">
                @endif
                <div class="mt-2 fw-bold text-primary">{{ ucfirst($theme) }}</div>
            </div>
            <div class="col-md-9">
                <div class="card-body">
                    <h2 class="card-title mb-2 text-primary">{{ $boutique->nom }}</h2>
                    <div class="mb-2">
                        <span class="fw-bold">Marchand :</span>
                        <a href="#" class="text-decoration-underline">{{ $boutique->user->name ?? 'Marchand' }}</a>
                    </div>
                    <div class="mb-2">
                        <span class="fw-bold">Localisation :</span> {{ $boutique->localisation ?? 'Non renseignée' }}
                    </div>
                    @if($boutique->offre)
                    <div class="mb-2">
                        <span class="badge bg-warning text-dark"><i class="bi bi-lightning-charge"></i> Offre spéciale : {{ $boutique->offre }}</span>
                    </div>
                    @endif
                    <div class="mb-3">
                        <a href="#" class="btn btn-outline-primary btn-sm me-2"><i class="bi bi-chat-dots"></i> Contacter la vendeuse</a>
                        <a href="#" class="btn btn-outline-success btn-sm me-2"><i class="bi bi-bell"></i> S’abonner à la boutique</a>
                        <a href="https://wa.me/?text=Découvrez%20la%20boutique%20{{ urlencode($boutique->nom) }}%20sur%20CabaCaba%20!%20{{ url()->current() }}" target="_blank" class="btn btn-outline-info btn-sm"><i class="bi bi-share"></i> Partager</a>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge bg-{{ $boutique->en_ligne ? 'success' : 'secondary' }}">{{ $boutique->en_ligne ? 'En ligne' : 'Hors ligne' }}</span>
                        <span class="ms-2"><i class="bi bi-star-fill text-warning"></i> {{ $boutique->note ?? '4.5' }}/5</span>
                        <span class="ms-2"><i class="bi bi-eye"></i> {{ $boutique->visites ?? 0 }} visites</span>
                        <span class="ms-2"><i class="bi bi-people"></i> {{ $boutique->clients ?? 0 }} clients</span>
                    </div>
                </div>
            </div>
        </div>
        @if(count($slides))
        <div class="row mt-3">
            <div class="col-12">
                <div id="carouselBusiness" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($slides as $k => $slide)
                        <div class="carousel-item @if($k==0) active @endif">
                            <img src="{{ asset('storage/'.$slide) }}" class="d-block w-100 rounded" style="max-height:220px;object-fit:cover;" alt="Slide {{ $k+1 }}">
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselBusiness" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselBusiness" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Suivant</span>
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
    @elseif($modele === 'pro')
    <div class="card mb-4 border-dark shadow animate__animated animate__fadeIn">
        <div class="row g-0 align-items-center">
            <div class="col-md-12 text-center p-4" style="background: linear-gradient(90deg, #f8fafc 60%, #e0e7ef 100%);">
                @if($logo)
                    <img src="{{ $logo }}" class="img-fluid rounded mb-2" style="max-width:160px;max-height:160px;object-fit:cover;" alt="Logo boutique">
                @else
                    <img src="https://via.placeholder.com/160x160?text=Logo" class="img-fluid rounded mb-2" alt="Logo boutique">
                @endif
                <h1 class="display-5 fw-bold text-dark">{{ $boutique->nom }}</h1>
                <div class="mb-2 text-muted">{{ ucfirst($theme) }} | {{ ucfirst($layout) }}</div>
                <div class="mb-2">
                    <span class="fw-bold">Marchand :</span>
                    <a href="#" class="text-decoration-underline">{{ $boutique->user->name ?? 'Marchand' }}</a>
                </div>
                <div class="mb-2">
                    <span class="fw-bold">Localisation :</span> {{ $boutique->localisation ?? 'Non renseignée' }}
                </div>
                @if($boutique->offre)
                <div class="mb-2">
                    <span class="badge bg-warning text-dark"><i class="bi bi-lightning-charge"></i> Offre spéciale : {{ $boutique->offre }}</span>
                </div>
                @endif
                <div class="d-flex justify-content-center gap-3 mb-2">
                    <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-chat-dots"></i> Contacter</a>
                    <a href="#" class="btn btn-outline-success btn-sm"><i class="bi bi-bell"></i> S’abonner</a>
                    <a href="https://wa.me/?text=Découvrez%20la%20boutique%20{{ urlencode($boutique->nom) }}%20sur%20CabaCaba%20!%20{{ url()->current() }}" target="_blank" class="btn btn-outline-info btn-sm"><i class="bi bi-share"></i> Partager</a>
                </div>
                <div class="d-flex justify-content-center gap-3">
                    <span class="badge bg-{{ $boutique->en_ligne ? 'success' : 'secondary' }}">{{ $boutique->en_ligne ? 'En ligne' : 'Hors ligne' }}</span>
                    <span class="ms-2"><i class="bi bi-star-fill text-warning"></i> {{ $boutique->note ?? '4.5' }}/5</span>
                    <span class="ms-2"><i class="bi bi-eye"></i> {{ $boutique->visites ?? 0 }} visites</span>
                    <span class="ms-2"><i class="bi bi-people"></i> {{ $boutique->clients ?? 0 }} clients</span>
                </div>
            </div>
        </div>
        @if(count($slides))
        <div class="row mt-3">
            <div class="col-12">
                <div id="carouselPro" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($slides as $k => $slide)
                        <div class="carousel-item @if($k==0) active @endif">
                            <img src="{{ asset('storage/'.$slide) }}" class="d-block w-100 rounded" style="max-height:260px;object-fit:cover;" alt="Slide {{ $k+1 }}">
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselPro" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselPro" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Suivant</span>
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
    @else {{-- modèle classique ou par défaut --}}
    <div class="card mb-4 animate__animated animate__fadeIn">
        <div class="row g-0 align-items-center">
            <div class="col-md-4">
                @if($logo)
                    <img src="{{ $logo }}" class="img-fluid rounded-start w-100 border border-2 border-secondary" style="max-height:200px;object-fit:cover;" alt="Logo boutique">
                @else
                    <img src="{{ $boutique->image ?? 'https://via.placeholder.com/400x200?text=Boutique' }}" class="img-fluid rounded-start w-100" alt="Image boutique">
                @endif
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h2 class="card-title mb-2">{{ $boutique->nom }}</h2>
                    <div class="mb-2">
                        <span class="fw-bold">Marchand :</span>
                        <a href="#" class="text-decoration-underline">{{ $boutique->user->name ?? 'Marchand' }}</a>
                    </div>
                    <div class="mb-2">
                        <span class="fw-bold">Localisation :</span> {{ $boutique->localisation ?? 'Non renseignée' }}
                    </div>
                    @if($boutique->offre)
                    <div class="mb-2">
                        <span class="badge bg-warning text-dark"><i class="bi bi-lightning-charge"></i> Offre spéciale : {{ $boutique->offre }}</span>
                    </div>
                    @endif
                    <div class="mb-3">
                        <a href="#" class="btn btn-outline-primary btn-sm me-2"><i class="bi bi-chat-dots"></i> Contacter la vendeuse</a>
                        <a href="#" class="btn btn-outline-success btn-sm me-2"><i class="bi bi-bell"></i> S’abonner à la boutique</a>
                        <a href="https://wa.me/?text=Découvrez%20la%20boutique%20{{ urlencode($boutique->nom) }}%20sur%20CabaCaba%20!%20{{ url()->current() }}" target="_blank" class="btn btn-outline-info btn-sm"><i class="bi bi-share"></i> Partager</a>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge bg-{{ $boutique->en_ligne ? 'success' : 'secondary' }}">{{ $boutique->en_ligne ? 'En ligne' : 'Hors ligne' }}</span>
                        <span class="ms-2"><i class="bi bi-star-fill text-warning"></i> {{ $boutique->note ?? '4.5' }}/5</span>
                        <span class="ms-2"><i class="bi bi-eye"></i> {{ $boutique->visites ?? 0 }} visites</span>
                        <span class="ms-2"><i class="bi bi-people"></i> {{ $boutique->clients ?? 0 }} clients</span>
                    </div>
                </div>
            </div>
        </div>
        @if(count($slides))
        <div class="row mt-3">
            <div class="col-12">
                <div id="carouselClassique" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($slides as $k => $slide)
                        <div class="carousel-item @if($k==0) active @endif">
                            <img src="{{ asset('storage/'.$slide) }}" class="d-block w-100 rounded" style="max-height:180px;object-fit:cover;" alt="Slide {{ $k+1 }}">
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselClassique" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselClassique" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Suivant</span>
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Section à propos et livraison -->
    <div class="row mb-4">
        <div class="col-md-6 mb-2">
            <div class="card h-100">
                <div class="card-header bg-light fw-bold">À propos de la boutique</div>
                <div class="card-body">
                    {{ $boutique->a_propos ?? 'Non renseigné.' }}
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="card h-100">
                <div class="card-header bg-light fw-bold">Livraison</div>
                <div class="card-body">
                    <div><span class="fw-bold">Délais :</span> {{ $boutique->livraison ?? 'Non renseigné' }}</div>
                    <div><span class="fw-bold">Zones desservies :</span> {{ $boutique->zone_livraison ?? 'Non renseigné' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Produits vedette -->
    @php
        $vedettes = $boutique->produits->where('vedette', true);
        $autres = $boutique->produits->where('vedette', false);
    @endphp
    @if($vedettes->count())
    <h4 class="mb-3 text-primary"><i class="bi bi-star-fill"></i> Produits vedette</h4>
    <div class="row g-3 mb-4">
        @foreach($vedettes as $produit)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-primary border-2">
                <img src="{{ $produit->image ?? 'https://via.placeholder.com/300x200?text=Produit' }}" class="card-img-top" alt="Image produit">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">
                        {{ $produit->nom }}
                        <span class="badge bg-primary ms-2"><i class="bi bi-star-fill"></i> Vedette</span>
                    </h5>
                    <div class="mb-2">Prix : <span class="fw-bold">{{ number_format($produit->prix, 2, ',', ' ') }} FCFA</span></div>
                    <div class="mb-2">Cashback : <span class="badge bg-success">+{{ $boutique->cashbacks->first()->taux ?? 0 }}%</span></div>
                    <a href="#" class="btn btn-cbm mt-auto"><i class="bi bi-cart"></i> Acheter</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Produits de la boutique -->
    <h4 class="mb-3">Produits de la boutique</h4>
    <form method="GET" class="mb-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="q" class="form-control" placeholder="Rechercher un produit..." value="{{ request('q') }}">
            </div>
            <div class="col-md-3">
                <input type="number" name="prix_min" class="form-control" placeholder="Prix min" value="{{ request('prix_min') }}">
            </div>
            <div class="col-md-3">
                <input type="number" name="prix_max" class="form-control" placeholder="Prix max" value="{{ request('prix_max') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-cbm w-100" type="submit"><i class="bi bi-search"></i> Filtrer</button>
            </div>
        </div>
    </form>
    <div class="row g-3">
        @forelse($autres as $produit)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100">
                <img src="{{ $produit->image ?? 'https://via.placeholder.com/300x200?text=Produit' }}" class="card-img-top" alt="Image produit">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $produit->nom }}</h5>
                    <div class="mb-2">Prix : <span class="fw-bold">{{ number_format($produit->prix, 2, ',', ' ') }} FCFA</span></div>
                    <div class="mb-2">Cashback : <span class="badge bg-success">+{{ $boutique->cashbacks->first()->taux ?? 0 }}%</span></div>
                    <a href="#" class="btn btn-cbm mt-auto"><i class="bi bi-cart"></i> Acheter</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">Aucun produit disponible pour cette boutique.</div>
        </div>
        @endforelse
    </div>

    <!-- Avis clients -->
    @include('boutiques.partials.avis', ['boutique' => $boutique])
</div>
@endsection
