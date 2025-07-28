@extends('layouts.boutique')

@section('title', 'Mes cashbacks remboursés')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Cashbacks remboursés</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Montant (€)</th>
                <th>Date de remboursement</th>
                <th>Accusé</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cashbacks as $cashback)
                <tr>
                    <td>{{ $cashback->id }}</td>
                    <td>{{ $cashback->user->name ?? '-' }}</td>
                    <td>{{ number_format($cashback->montant, 2, ',', ' ') }}</td>
                    <td>{{ $cashback->updated_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('boutique.cashbacks.accuse', $cashback) }}" class="btn btn-outline-info btn-sm">Voir l'accusé</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
