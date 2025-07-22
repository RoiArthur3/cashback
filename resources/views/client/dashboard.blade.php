@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h1 class="mb-4">Espace Client</h1>
    <div class="alert alert-primary">Bienvenue, vous pouvez consulter vos gains et profiter des offres cashback.</div>
    <a href="{{ route('client.achats') }}" class="btn btn-outline-primary mb-3">
        <i class="bi bi-clock-history"></i> Voir mon historique d’achats
    </a>
    <!-- Ajoutez ici les actions client -->
</div>
@endsection
