@extends('account.index')
@section('account-content')
<div class="card mb-4">
    <div class="card-body">
        <h4 class="mb-3">Ma boutique</h4>
        @if($boutique)
            <div class="mb-3">
                <strong>Nom :</strong> {{ $boutique->nom }}<br>
                <strong>Modèle :</strong> {{ ucfirst($boutique->modele) }}<br>
                <strong>Thème :</strong> {{ ucfirst($boutique->theme) }}<br>
                <strong>Dernière modification :</strong> {{ $boutique->updated_at->format('d/m/Y H:i') }}
            </div>
            <a href="{{ route('boutiques.edit', $boutique->id) }}" class="btn btn-cbm"><i class="bi bi-pencil-square me-1"></i> Modifier ma boutique</a>
        @else
            <div class="alert alert-warning">Vous n'avez pas encore de boutique.</div>
        @endif
    </div>
</div>
@endsection
