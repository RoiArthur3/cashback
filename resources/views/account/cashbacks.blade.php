@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3 mb-3">
            @include('account.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-cash-coin"></i> Mes cashbacks</h5>
                </div>
                <div class="card-body">
                    @if($cashbacks->count() > 0)
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ number_format($cashbacks->sum('cashback_montant'), 0, ',', ' ') }} FCFA</h4>
                                        <div>Total cashback cumulé</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-info text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ $cashbacks->count() }}</h4>
                                        <div>Achats avec cashback</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-warning text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ number_format($cashbacks->where('created_at', '>=', now()->startOfMonth())->sum('cashback_montant'), 0, ',', ' ') }} FCFA</h4>
                                        <div>Ce mois-ci</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Produit</th>
                                        <th>Montant achat</th>
                                        <th>Cashback</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cashbacks->sortByDesc('created_at') as $achat)
                                        <tr>
                                            <td>{{ $achat->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $achat->produit->nom ?? 'Produit supprimé' }}</td>
                                            <td>{{ number_format($achat->montant, 0, ',', ' ') }} FCFA</td>
                                            <td class="text-success fw-bold">+{{ number_format($achat->cashback_montant, 0, ',', ' ') }} FCFA</td>
                                            <td><span class="badge bg-success">Validé</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-cash-coin fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun cashback pour le moment</h5>
                            <p class="text-muted">Effectuez des achats pour commencer à cumuler du cashback !</p>
                            <a href="{{ route('boutiques.index') }}" class="btn btn-primary">Découvrir les boutiques</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
