@extends('layouts.admin')

@section('title', 'Comptabilité - Mouvements')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Mouvements comptables</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Utilisateur</th>
                <th>Boutique</th>
                <th>Cashback</th>
                <th>Montant (€)</th>
                <th>Référence</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mouvements as $mouvement)
                <tr>
                    <td>{{ $mouvement->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ ucfirst($mouvement->type) }}</td>
                    <td>{{ $mouvement->user->name ?? '-' }}</td>
                    <td>{{ $mouvement->boutique->nom ?? '-' }}</td>
                    <td>{{ $mouvement->cashback_id ?? '-' }}</td>
                    <td>{{ number_format($mouvement->montant, 2, ',', ' ') }}</td>
                    <td>{{ $mouvement->reference ?? '-' }}</td>
                    <td>{{ $mouvement->description ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-3">
        {{ $mouvements->links() }}
    </div>
</div>
@endsection
