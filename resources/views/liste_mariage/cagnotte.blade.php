@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Cagnotte pour {{ $liste->nom_couple ?? 'cette liste de mariage' }}</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="fw-bold">Montant total collecté :</h5>
                        <div class="display-5 text-success">{{ number_format($cagnotte->montant_total ?? 0, 0, ',', ' ') }} FCFA</div>
                    </div>
                    <form method="POST" action="{{ route('liste-mariage.cagnotte.contribuer', $liste->id) }}" class="mb-4">
                        @csrf
                        <div class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label for="montant" class="form-label">Montant à offrir</label>
                                <input type="number" min="1" class="form-control" name="montant" id="montant" required>
                            </div>
                            <div class="col-md-4">
                                <label for="nom_contributeur" class="form-label">Votre nom (optionnel)</label>
                                <input type="text" class="form-control" name="nom_contributeur" id="nom_contributeur">
                            </div>
                            <div class="col-md-4">
                                <label for="message" class="form-label">Message (optionnel)</label>
                                <input type="text" class="form-control" name="message" id="message">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Contribuer à la cagnotte</button>
                    </form>
                    <h5 class="mt-4">Contributions récentes</h5>
                    <ul class="list-group">
                        @forelse($contributions as $contrib)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <strong>{{ $contrib->nom_contributeur ?? ($contrib->user->name ?? 'Anonyme') }}</strong>
                                    @if($contrib->message)
                                        <span class="text-muted">- {{ $contrib->message }}</span>
                                    @endif
                                </span>
                                <span class="badge bg-success">+{{ number_format($contrib->montant, 0, ',', ' ') }} FCFA</span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Aucune contribution pour le moment.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
