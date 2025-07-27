@extends('layouts.app')
@section('content')
@php
    $mainColor = $boutique->couleur_principale ?? '#F6E7B2';
    $accentColor = $boutique->couleur_accent ?? '#8B6B5C';
    $textColor = $boutique->couleur_texte ?? '#3B2F2F';
    $logo = $boutique->logo ?? 'https://via.placeholder.com/120x120?text=Logo';
    $image = $boutique->slides[0] ?? 'https://via.placeholder.com/600x400?text=Boutique';
    $cashback = $boutique->cashbacks->first()->taux ?? 0;
    $annee = $boutique->annee ?? date('Y');
    $slogan = $boutique->slogan ?? $boutique->categorie ?? '';
    $desc = $boutique->description_courte ?? Str::limit(strip_tags($boutique->a_propos), 180) ?? '';
    $site = $boutique->site_web ?? url()->current();
    $qr = $boutique->qr_code ?? 'https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=' . urlencode($site);
@endphp
<style>
.boutique-landing-bg {
    background: {{ $mainColor }};
    padding: 2.5rem 0 0 0;
}
.boutique-landing-card {
    max-width: 1100px;
    margin: 0 auto;
    background: #fff;
    border-radius: 1.5rem;
    box-shadow: 0 4px 32px rgba(34,34,59,0.13);
    display: flex;
    overflow: hidden;
    position: relative;
}
.boutique-landing-left {
    width: 45%;
    min-width: 280px;
    background: #fff;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    padding: 2rem 1.2rem 1.2rem 2rem;
    position: relative;
    justify-content: center;
}
.boutique-cb-vertical {
    position: absolute;
    left: -2.2rem;
    top: 2rem;
    background: {{ $accentColor }};
    color: #fff;
    font-weight: bold;
    font-size: 1.3rem;
    padding: 0.8rem 0.5rem;
    border-radius: 0.5rem;
    writing-mode: vertical-rl;
    text-orientation: mixed;
    letter-spacing: 0.1em;
    box-shadow: 0 2px 8px rgba(34,34,59,0.07);
    z-index: 2;
}
.boutique-img-container {
    width: 100%;
    max-width: 320px;
    height: 220px;
    position: relative;
    margin-bottom: 1.2rem;
}
.boutique-main-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 1rem;
    box-shadow: 0 2px 8px rgba(34,34,59,0.07);
}
.boutique-logo-overlay {
    position: absolute;
    top: 12px;
    left: 12px;
    width: 70px;
    height: 70px;
    object-fit: contain;
    border-radius: 0.5rem;
    background: #fff;
    box-shadow: 0 2px 8px rgba(34,34,59,0.10);
    padding: 6px;
    z-index: 3;
}
.boutique-annee {
    margin-top: auto;
    font-size: 1.1rem;
    color: {{ $accentColor }};
    font-weight: bold;
    background: #f8f8f8;
    border-radius: 0.5rem;
    padding: 0.4rem 1rem;
}
.boutique-landing-right {
    width: 55%;
    min-width: 260px;
    background: {{ $accentColor }};
    color: #fff;
    padding: 2.2rem 2.2rem 1.5rem 2rem;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    position: relative;
    min-height: 220px;
}
.boutique-qr {
    position: absolute;
    top: 1.2rem;
    right: 1.2rem;
    background: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 2px 8px rgba(34,34,59,0.10);
    padding: 6px;
    z-index: 4;
}
.boutique-title {
    font-size: 2.3rem;
    font-weight: bold;
    color: #fffbe7;
    margin-bottom: 0.5rem;
    letter-spacing: 0.02em;
}
.boutique-slogan {
    font-size: 1.2rem;
    color: #ffe7a0;
    margin-bottom: 1.1rem;
    font-weight: 500;
}
.boutique-desc {
    font-size: 1.05rem;
    color: #fff;
    margin-bottom: 1.2rem;
    max-width: 600px;
}
.boutique-landing-btn {
    background: {{ $mainColor }};
    color: {{ $accentColor }};
    border: none;
    border-radius: 0.5rem;
    padding: 0.7rem 2.2rem;
    font-size: 1.1rem;
    font-weight: bold;
    box-shadow: 0 2px 8px rgba(34,34,59,0.07);
    transition: background 0.2s, color 0.2s;
}
.boutique-landing-btn:hover {
    background: #fff;
    color: {{ $accentColor }};
}
.boutique-footer {
    max-width: 1100px;
    margin: 0 auto;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 0.7rem 2.5rem 0.2rem 2.5rem;
    color: {{ $accentColor }};
    font-size: 1.1rem;
}
.boutique-footer .boutique-link {
    color: {{ $accentColor }};
    font-weight: bold;
    text-decoration: underline;
    margin-right: 1.5rem;
    font-size: 1.1rem;
}
.boutique-footer .socials a {
    color: {{ $accentColor }};
    font-size: 1.4rem;
    margin-left: 1.2rem;
    transition: color 0.2s;
}
.boutique-footer .socials a:hover {
    color: {{ $mainColor }};
}
@media (max-width: 900px) {
    .boutique-landing-card { flex-direction: column; }
    .boutique-landing-left, .boutique-landing-right { width: 100%; min-width: 0; padding: 1.2rem; }
    .boutique-main-img { max-width: 100%; height: 180px; }
    .boutique-footer { flex-direction: column; gap: 0.7rem; padding: 1rem; justify-content: center; }
    .boutique-footer .boutique-link { margin-right: 0; margin-bottom: 0.7rem; }
    .boutique-qr { position: static; margin-bottom: 1rem; }
}
.boutique-annee-btn {
    font-size: 1.1rem;
    font-weight: bold;
    border-radius: 0.5rem;
    padding: 0.4rem 1.2rem;
    line-height: 1.2;
    margin-bottom: 0.5rem;
}
</style>
@if(isset($boutique) && $boutique)
<div class="boutique-landing-bg">
  <div class="boutique-landing-card position-relative">
    <div class="boutique-landing-left">
      <div class="boutique-cb-vertical">{{ $cashback }}% CB</div>
      <div class="boutique-img-container">
        <img src="{{ $image }}" class="boutique-main-img" alt="Image principale">
        <img src="{{ $logo }}" class="boutique-logo-overlay" alt="Logo">
      </div>
      @if(!isset($boutique->afficher_annee) || $boutique->afficher_annee)
      <button class="btn btn-success boutique-annee-btn" style="margin-top:auto;">
        {{ $annee }}<br><span style="font-size:0.9rem;font-weight:400;">Nouveaux produits</span>
      </button>
      @endif
    </div>
    <div class="boutique-landing-right position-relative">
      <div class="boutique-qr"><img src="{{ $qr }}" alt="QR code" width="70" height="70"></div>
      <div class="boutique-title">En-tête boutique</div>
      <div class="boutique-title">{{ $boutique->nom }}</div>
      <div class="boutique-slogan">{{ $slogan }}</div>
      <div class="boutique-desc">{{ $desc }}</div>
      <a href="#plus" class="boutique-landing-btn mt-3">Découvrir</a>
      @php
        $user = Auth::user();
        $boutiques = method_exists($user, 'boutiques') ? $user->boutiques()->get() : collect([$boutique]);
      @endphp
      @if($boutiques->count() >= 2)
      <div class="d-flex gap-3 mt-4 justify-content-end">
        @foreach($boutiques->take(2) as $b)
        <div class="card shadow-sm text-center" style="width:110px;">
          <img src="{{ $b->logo ?? 'https://via.placeholder.com/100x100?text=Boutique' }}" class="card-img-top" style="width:100px;height:100px;object-fit:cover;margin:auto;">
          <div class="card-body p-2">
            <a href="{{ route('boutique.show', $b->id) }}" class="btn btn-outline-primary btn-sm w-100">Voir</a>
          </div>
        </div>
        @endforeach
      </div>
      @endif
    </div>
  </div>
  <div class="boutique-footer">
    <a href="{{ $site }}" target="_blank" class="boutique-link">{{ parse_url($site, PHP_URL_HOST) ?? $site }}</a>
    <div class="socials">
      <a href="#"><i class="bi bi-tiktok"></i></a>
      <a href="#"><i class="bi bi-instagram"></i></a>
      <a href="#"><i class="bi bi-facebook"></i></a>
    </div>
  </div>
</div>
@endif
<style>
    .boutique-banner {
        position: relative;
        width: 100%;
        height: 320px;
        background: #f8f9fa;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .boutique-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.85);
    }
    .boutique-info-floating {
        position: absolute;
        left: 2rem;
        bottom: 2rem;
        background: rgba(255,255,255,0.95);
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(34,34,59,0.13);
        padding: 2rem 2.5rem;
        min-width: 320px;
        max-width: 90vw;
        z-index: 2;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    @media (max-width: 700px) {
        .boutique-info-floating {
            left: 50%;
            bottom: 1rem;
            transform: translateX(-50%);
            padding: 1rem 1rem;
            min-width: 0;
            width: 95vw;
        }
    }
    .boutique-action-btns {
        margin-top: 1rem;
        display: flex;
        gap: 1rem;
    }
</style>
@if(Auth::user() && Auth::user()->role_name === 'commercant' && !$boutique)
    <div class="container py-5 text-center">
        <h2 class="mb-4 text-success fw-bold">Créez votre boutique et boostez votre business !</h2>
        <p class="lead mb-4">Rejoignez la plateforme cashback la plus dynamique de Côte d'Ivoire et profitez de nombreux avantages :</p>
        <ul class="list-unstyled mb-4">
            <li class="mb-2"><i class="bi bi-cash-coin text-primary"></i> Générez des revenus supplémentaires grâce au cashback</li>
            <li class="mb-2"><i class="bi bi-people text-primary"></i> Touchez une large clientèle locale et engagée</li>
            <li class="mb-2"><i class="bi bi-bar-chart-line text-primary"></i> Suivez vos ventes et vos performances en temps réel</li>
            <li class="mb-2"><i class="bi bi-phone text-primary"></i> Gérez facilement votre boutique depuis votre espace commerçant</li>
        </ul>
        <a href="{{ url('/boutiques/create') }}" class="btn btn-lg btn-success px-5 py-3"><i class="bi bi-plus-circle"></i> Créer ma boutique maintenant</a>
    </div>
@else
    @if(isset($boutique) && $boutique)
    <div class="boutique-banner">
        <img src="{{ $boutique->logo ?? ($boutique->slides[0] ?? 'https://via.placeholder.com/1200x320?text=Boutique') }}" alt="Image boutique">
        <div class="boutique-info-floating">
            <h2 class="mb-1 fw-bold">{{ $boutique->nom }}</h2>
            <div><span class="fw-bold">Marchand :</span> {{ $boutique->user->name ?? 'Marchand' }}</div>
            <div><span class="fw-bold">Localisation :</span> {{ $boutique->localisation ?? 'Non renseignée' }}</div>
            @if($boutique->offre)
            <div><span class="badge bg-warning text-dark"><i class="bi bi-lightning-charge"></i> Offre spéciale : {{ $boutique->offre }}</span></div>
            @endif
            <div><span class="badge bg-secondary">Hors ligne</span></div>
            <div><i class="bi bi-star-fill text-warning"></i> {{ $boutique->note ?? '4.5' }}/5</div>
            <div><i class="bi bi-eye"></i> {{ $boutique->visites ?? 0 }} visites</div>
            <div><i class="bi bi-people"></i> {{ $boutique->clients ?? 0 }} clients</div>
            <div class="boutique-action-btns">
                <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-share"></i> Partager</a>
                <a href="#contact" class="btn btn-success btn-sm"><i class="bi bi-envelope"></i> Contacter</a>
            </div>
        </div>
    </div>
    <div class="container py-4">
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
    @else
    <div class="container py-5 text-center">
        <h2 class="mb-4 text-danger fw-bold">Boutique introuvable</h2>
        <p class="lead">La boutique demandée n'existe pas ou a été supprimée.</p>
    </div>
    @endif
@endif
@endsection
