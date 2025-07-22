@extends('layouts.app')
@section('content')
<div class="container py-4 text-center">
    <h2 class="mb-4 text-success">Boutique créée avec succès !</h2>
    <p>Identifiant de la boutique : <strong>{{ $id }}</strong></p>
    <a href="{{ $lien }}" class="btn btn-primary">Voir la boutique</a>
    <div class="mt-4">
        <a href="{{ route('boutiques.index') }}" class="btn btn-outline-secondary">Retour à la liste des boutiques</a>
    </div>
</div>
@endsection
