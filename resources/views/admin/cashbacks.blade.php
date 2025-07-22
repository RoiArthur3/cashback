@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Gestion des cashback</h2>
    <div class="alert alert-secondary">Gérez les taux de cashback et les offres spéciales.</div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle bg-white">
            <thead class="table-light">
                <tr>
                    <th>Boutique</th>
                    <th>Taux de cashback</th>
                    <th>Offre spéciale</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cashbacks ?? [] as $cb)
                <tr>
                    <td>{{ $cb->boutique }}</td>
                    <td><span class="badge bg-success">+{{ $cb->taux }}%</span></td>
                    <td>{{ $cb->offre ?? '-' }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">Modifier</a>
                        <a href="#" class="btn btn-sm btn-danger">Supprimer</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="#" class="btn btn-cbm mt-3"><i class="bi bi-plus-circle"></i> Ajouter un cashback</a>
</div>
@endsection
