@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">@if(isset($produit)) Modifier le produit @else Ajouter un produit @endif</h2>
    <form action="@if(isset($produit)){{ route('partenaire.produits.update', $produit->id) }}@else{{ route('partenaire.produits.store') }}@endif" method="POST">
        @csrf
        @if(isset($produit)) @method('PUT') @endif
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du produit</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $produit->nom ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $produit->description ?? '') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="prix" class="form-label">Prix (FCFA)</label>
            <input type="number" step="0.01" class="form-control" id="prix" name="prix" value="{{ old('prix', $produit->prix ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image (URL)</label>
            <input type="text" class="form-control" id="image" name="image" value="{{ old('image', $produit->image ?? '') }}">
        </div>
        <button type="submit" class="btn btn-cbm">Enregistrer</button>
        <a href="{{ route('partenaire.produits') }}" class="btn btn-secondary ms-2">Annuler</a>
    </form>
</div>
@endsection
