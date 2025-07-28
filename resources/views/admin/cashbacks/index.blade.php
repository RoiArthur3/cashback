@extends('layouts.admin')

@section('title', 'Gestion des Cashbacks')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Cashbacks à valider et à rembourser</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Boutique</th>
                <th>Montant (€)</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cashbacks as $cashback)
                <tr>
                    <td>{{ $cashback->id }}</td>
                    <td>{{ $cashback->user->name ?? '-' }}</td>
                    <td>{{ $cashback->boutique->nom ?? '-' }}</td>
                    <td>{{ number_format($cashback->montant, 2, ',', ' ') }}</td>
                    <td>
                        @if($cashback->statut === 'en_attente')
                            <span class="badge bg-warning">En attente</span>
                        @elseif($cashback->statut === 'valide')
                            <span class="badge bg-success">Validé</span>
                        @elseif($cashback->statut === 'rembourse')
                            <span class="badge bg-primary">Remboursé</span>
                        @endif
                    </td>
                    <td>{{ $cashback->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($cashback->statut === 'en_attente')
                            <form action="{{ route('admin.cashbacks.valider', $cashback) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Valider</button>
                            </form>
                        @elseif($cashback->statut === 'valide')
                            <form action="{{ route('admin.cashbacks.rembourser', $cashback) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Rembourser</button>
                            </form>
                        @elseif($cashback->statut === 'rembourse')
                            <a href="{{ route('admin.cashbacks.accuse', $cashback) }}" class="btn btn-outline-info btn-sm">Voir l'accusé</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
