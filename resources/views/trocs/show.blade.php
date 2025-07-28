@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                @if($troc->image)
                    <img src="{{ Storage::url($troc->image) }}" class="card-img-top" alt="Troc image">
                @endif
                <div class="card-body">
                    <h3 class="card-title">{{ $troc->titre }}</h3>
                    <p class="text-muted">Par {{ $troc->user->name }}</p>
                    <p>{{ $troc->description }}</p>
                    <span class="badge bg-{{ $troc->statut == 'actif' ? 'success' : ($troc->statut == 'termine' ? 'secondary' : 'danger') }}">{{ ucfirst($troc->statut) }}</span>
                </div>
            </div>
            @if($troc->statut == 'actif' && Auth::id() !== $troc->user_id)
            <div class="card mb-4">
                <div class="card-header">Proposer un échange</div>
                <div class="card-body">
                    <form action="{{ route('trocs.proposerOffre', $troc) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control" name="description_offre" rows="3" placeholder="Décrivez votre offre" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer l'offre</button>
                    </form>
                </div>
            </div>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Offres reçues</div>
                <div class="card-body">
                    @forelse($troc->offres as $offre)
                        <div class="mb-3 p-2 border rounded">
                            <div class="fw-bold">{{ $offre->user->name }}</div>
                            <div>{{ $offre->description_offre }}</div>
                            <span class="badge bg-{{ $offre->statut == 'accepte' ? 'success' : ($offre->statut == 'refuse' ? 'danger' : 'warning') }}">{{ ucfirst($offre->statut) }}</span>
                            @if(Auth::id() === $troc->user_id && $offre->statut == 'en_attente' && $troc->statut == 'actif')
                                <form action="{{ route('trocs.accepterOffre', [$troc, $offre]) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Accepter</button>
                                </form>
                                <form action="{{ route('trocs.refuserOffre', [$troc, $offre]) }}" method="POST" class="d-inline ms-2">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Refuser</button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <div class="text-muted">Aucune offre pour ce troc.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
