@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">@if(isset($cashback)) Modifier le cashback @else Ajouter un cashback @endif</h2>
    <form action="@if(isset($cashback)){{ route('partenaire.cashbacks.update', $cashback->id) }}@else{{ route('partenaire.cashbacks.store') }}@endif" method="POST">
        @csrf
        @if(isset($cashback)) @method('PUT') @endif
        <div class="mb-3">
            <label for="taux" class="form-label">Taux de cashback (%)</label>
            <input type="number" step="0.01" class="form-control" id="taux" name="taux" value="{{ old('taux', $cashback->taux ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label for="offre" class="form-label">Offre spéciale</label>
            <input type="text" class="form-control" id="offre" name="offre" value="{{ old('offre', $cashback->offre ?? '') }}">
        </div>
        <button type="submit" class="btn btn-cbm">Enregistrer</button>
        <a href="{{ route('partenaire.cashbacks') }}" class="btn btn-secondary ms-2">Annuler</a>
    </form>
</div>
@endsection
