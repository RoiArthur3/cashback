@extends('layouts.boutique')

@section('title', "Accusé de remboursement du cashback #" . $cashback->id)

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3>Accusé de remboursement</h3>
        </div>
        <div class="card-body">
            <p><strong>ID du cashback :</strong> {{ $cashback->id }}</p>
            <p><strong>Bénéficiaire :</strong> {{ $cashback->user->name ?? '-' }}</p>
            <p><strong>Montant remboursé :</strong> {{ number_format($cashback->montant, 2, ',', ' ') }} €</p>
            <p><strong>Date de remboursement :</strong> {{ $cashback->updated_at->format('d/m/Y H:i') }}</p>
            <p><strong>Référence :</strong> {{ $cashback->reference ?? '-' }}</p>
            <hr>
            <p class="text-success">Ce cashback a été remboursé par CBM à votre boutique.</p>
        </div>
    </div>
    <a href="{{ route('boutique.cashbacks.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
@endsection
