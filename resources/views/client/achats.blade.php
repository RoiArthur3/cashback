@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Mon historique d’achats</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle bg-white">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Boutique</th>
                    <th>Produit</th>
                    <th>Montant</th>
                    <th>Cashback</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($achats as $achat)
                <tr>
                    <td>{{ $achat->created_at->format('d/m/Y') }}</td>
                    <td>{{ $achat->boutique->nom ?? '-' }}</td>
                    <td>{{ $achat->produit->nom ?? '-' }}</td>
                    <td>{{ number_format($achat->montant, 2, ',', ' ') }} FCFA</td>
                    <td><span class="badge bg-success">+{{ number_format($achat->cashback, 2, ',', ' ') }} FCFA</span></td>
                    <td>
                        @if($achat->statut === 'valide')
                            <span class="badge bg-success">Validé</span>
                        @elseif($achat->statut === 'refuse')
                            <span class="badge bg-danger">Refusé</span>
                        @else
                            <span class="badge bg-warning text-dark">En attente</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">Aucun achat enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
