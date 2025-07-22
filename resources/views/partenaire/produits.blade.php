@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Gestion des produits de ma boutique</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="mb-3">
        <a href="{{ route('partenaire.produits.create') }}" class="btn btn-cbm">Ajouter un produit</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle bg-white">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produits as $produit)
                <tr>
                    <td>{{ $produit->nom }}</td>
                    <td>{{ $produit->description }}</td>
                    <td>{{ number_format($produit->prix, 2, ',', ' ') }} FCFA</td>
                    <td>
                        @if($produit->image)
                            <img src="{{ $produit->image }}" alt="Image" style="max-width:60px;max-height:60px;">
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('partenaire.produits.edit', $produit->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('partenaire.produits.delete', $produit->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce produit ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">Aucun produit enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
