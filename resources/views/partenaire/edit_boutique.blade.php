@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">@if($boutique && $boutique->exists) Modifier ma boutique @else Créer ma boutique @endif</h2>
    <form action="{{ route('partenaire.boutique.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nom" class="form-label">Nom de la boutique</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $boutique->nom) }}" required>
        </div>
        <div class="mb-3">
            <label for="categorie" class="form-label">Catégorie</label>
            <input type="text" class="form-control" id="categorie" name="categorie" value="{{ old('categorie', $boutique->categorie) }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $boutique->description) }}</textarea>
        </div>
        <button type="submit" class="btn btn-cbm">Enregistrer</button>
        <a href="{{ route('partenaire.dashboard') }}" class="btn btn-secondary ms-2">Annuler</a>
    </form>
</div>
@endsection
