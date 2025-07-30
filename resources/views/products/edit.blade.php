
@extends('layouts.app')

@section('title', 'Modifier le produit')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body">
                    <h1 class="mb-4 text-center text-primary fw-bold">Modifier le produit</h1>
                    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nom" class="form-label fw-bold">Nom du produit</label>
                            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $product->nom) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="prix" class="form-label fw-bold">Prix (€)</label>
                            <input type="number" name="prix" id="prix" class="form-control" step="0.01" value="{{ old('prix', $product->prix) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="cashback" class="form-label fw-bold">Montant du cashback (€)</label>
                            <input type="number" name="cashback" id="cashback" class="form-control" step="0.01" value="{{ old('cashback', $product->cashback) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label fw-bold">Image du produit</label>
                            <input type="file" name="image" id="image" class="form-control">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="Image actuelle" class="img-thumbnail mt-2" style="max-width: 150px;">
                            @endif
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold">Enregistrer les modifications</button>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary w-100 mt-2">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
