
@extends('layouts.app')

@section('title', 'Liste des produits')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center">Nos produits en cashback</h1>
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $product->image_url ?? asset('images/default-product.png') }}" class="card-img-top" alt="{{ $product->nom }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->nom }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text fw-bold text-success">Cashback : {{ $product->cashback }} €</p>
                        <p class="card-text">Prix : <span class="fw-bold">{{ $product->prix }} €</span></p>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary mt-auto">Voir le produit</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Aucun produit disponible pour le moment.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
