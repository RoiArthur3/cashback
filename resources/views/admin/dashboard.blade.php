@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h1 class="mb-4">Espace Administrateur</h1>
    <div class="alert alert-info">Bienvenue, vous pouvez gérer tous les éléments du site.</div>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <a href="{{ route('admin.users') }}" class="btn btn-primary w-100 py-3"><i class="bi bi-people"></i> Gérer les utilisateurs</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.boutiques') }}" class="btn btn-success w-100 py-3"><i class="bi bi-shop"></i> Gérer les boutiques</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.cashbacks') }}" class="btn btn-info w-100 py-3"><i class="bi bi-cash-coin"></i> Gérer les cashback</a>
        </div>
    </div>
    <!-- Ajoutez ici les actions admin -->
</div>
@endsection
