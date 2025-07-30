
@extends('layouts.app')

@section('title', $product->nom)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4 shadow-lg border-0">
                <div class="row g-0 align-items-center">
                    <div class="col-md-5 text-center bg-light rounded-start">
                        <img src="{{ $product->image_url ?? asset('images/default-product.png') }}" class="img-fluid p-3" alt="{{ $product->nom }}" style="max-height: 250px; object-fit: contain;">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h2 class="card-title fw-bold text-primary mb-2">{{ $product->nom }}</h2>
                            <p class="card-text text-muted mb-3">{{ $product->description }}</p>
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-success me-2" style="font-size:1rem;">Cashback : {{ $product->cashback }} €</span>
                                <span class="badge bg-info text-dark" style="font-size:1rem;">Prix : {{ $product->prix }} €</span>
                            </div>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-primary mt-3">&#8592; Retour à la liste</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
