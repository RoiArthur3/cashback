@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Gestion des boutiques</h2>
    <div class="alert alert-secondary">Ajoutez, modifiez ou supprimez les boutiques partenaires.</div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle bg-white">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Cashback</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($boutiques ?? [] as $boutique)
                <tr>
                    <td>{{ $boutique->nom }}</td>
                    <td>{{ $boutique->categorie }}</td>
                    <td><span class="badge bg-success">+{{ $boutique->cashback }}%</span></td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">Modifier</a>
                        <a href="#" class="btn btn-sm btn-danger">Supprimer</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="#" class="btn btn-cbm mt-3"><i class="bi bi-plus-circle"></i> Ajouter une boutique</a>
</div>
@endsection
