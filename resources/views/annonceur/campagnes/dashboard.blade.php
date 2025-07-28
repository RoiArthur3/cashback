@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Mes campagnes publicitaires</h2>
    <a href="{{ route('annonceur.campagnes.create') }}" class="btn btn-success mb-3">+ Nouvelle campagne</a>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Statut</th>
                    <th>Budget</th>
                    <th>Impressions</th>
                    <th>Clics</th>
                    <th>Conversions</th>
                    <th>Ventes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($campagnes as $campagne)
                <tr>
                    <td>{{ $campagne->titre }}</td>
                    <td>{{ ucfirst($campagne->statut) }}</td>
                    <td>{{ number_format($campagne->budget, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $campagne->stats->impressions ?? 0 }}</td>
                    <td>{{ $campagne->stats->clics ?? 0 }}</td>
                    <td>{{ $campagne->stats->conversions ?? 0 }}</td>
                    <td>{{ $campagne->stats->ventes ?? 0 }}</td>
                    <td>
                        <a href="{{ route('annonceur.campagnes.show', $campagne) }}" class="btn btn-sm btn-info">Voir</a>
                        <a href="{{ route('annonceur.campagnes.edit', $campagne) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('annonceur.campagnes.destroy', $campagne) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette campagne ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center">Aucune campagne trouvée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
