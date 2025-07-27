@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Boutiques par catégories</h2>
    @foreach($categories as $categorie)
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">{{ $categorie->nom }}</div>
            <div class="card-body">
                @if($categorie->boutiques->count())
                    <ul class="list-group">
                        @foreach($categorie->boutiques as $boutique)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $boutique->nom }}</span>
                                <a href="{{ route('boutique.show', $boutique->id) }}" class="btn btn-sm btn-outline-info">Voir</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-muted">Aucune boutique dans cette catégorie.</div>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
