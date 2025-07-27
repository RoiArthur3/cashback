@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-5">
            <img src="{{ $produit->image ?? 'https://via.placeholder.com/400x300?text=Produit' }}" class="img-fluid rounded shadow" alt="{{ $produit->nom }}">
        </div>
        <div class="col-md-7">
            <h2 class="fw-bold mb-2">{{ $produit->nom }}</h2>
            <div class="mb-2 text-muted">Boutique : <a href="{{ route('boutique.show', $produit->boutique->id ?? 0) }}">{{ $produit->boutique->nom ?? '-' }}</a></div>
            <div class="fs-4 text-success mb-3">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</div>
            <div class="mb-3">{{ $produit->description }}</div>
            <div class="mb-2">
                <span class="badge bg-success">{{ $produit->achats_count ?? $produit->achats->count() }} ventes</span>
                @if($produit->vedette)
                    <span class="badge bg-warning text-dark">Produit vedette</span>
                @endif
            </div>
            <a href="#" class="btn btn-primary">Acheter</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Avis sur ce produit</h4>
            <div class="card p-3 mb-3">
                <div class="text-muted">Fonctionnalité à venir : affichage et ajout d'avis.</div>
            </div>
        </div>
    </div>
</div>
@endsection
