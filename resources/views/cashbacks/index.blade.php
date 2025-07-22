@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Liste des offres Cashback</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle bg-white">
            <thead class="table-light">
                <tr>
                    <th>Boutique</th>
                    <th>Type</th>
                    <th>Valeur</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cashbacks as $cashback)
                <tr>
                    <td>{{ $cashback->boutique->nom ?? '-' }}</td>
                    <td>{{ $cashback->type ?? '-' }}</td>
                    <td>
                        @if($cashback->type === 'pourcentage')
                            {{ $cashback->valeur }} %
                        @else
                            {{ number_format($cashback->valeur, 0, ',', ' ') }} FCFA
                        @endif
                    </td>
                    <td>{{ $cashback->description ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center">Aucune offre cashback disponible.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
