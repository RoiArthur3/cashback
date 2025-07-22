@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Tableau de bord Partenaire</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($boutique)
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Votre boutique : {{ $boutique->nom }}</h5>
                <p class="card-text">Catégorie : {{ $boutique->categorie ?? '-' }}</p>
                <p class="card-text">Description : {{ $boutique->description ?? '-' }}</p>
                <a href="{{ route('partenaire.boutique.edit') }}" class="btn btn-primary">Modifier</a>
                <form action="{{ route('partenaire.boutique.delete') }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer la boutique ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-info">Vous n'avez pas encore de boutique.</div>
        <a href="{{ route('partenaire.boutique.edit') }}" class="btn btn-success">Créer ma boutique</a>
    @endif
</div>
@endsection
