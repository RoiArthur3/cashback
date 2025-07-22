@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Gestion des cashback de ma boutique</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="mb-3">
        <a href="{{ route('partenaire.cashbacks.create') }}" class="btn btn-cbm">Ajouter un cashback</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle bg-white">
            <thead class="table-light">
                <tr>
                    <th>Taux</th>
                    <th>Offre spéciale</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cashbacks as $cb)
                <tr>
                    <td><span class="badge bg-success">+{{ $cb->taux }}%</span></td>
                    <td>{{ $cb->offre ?? '-' }}</td>
                    <td>
                        <a href="{{ route('partenaire.cashbacks.edit', $cb->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('partenaire.cashbacks.delete', $cb->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce cashback ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center">Aucun cashback défini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
