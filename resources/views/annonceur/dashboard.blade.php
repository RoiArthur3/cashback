@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">Espace Annonceur</div>
                <div class="card-body">
                    <h5 class="mb-3">Bienvenue, {{ $user->name }} !</h5>
                    <ul class="list-group mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Mes annonces</span>
                            <a href="#" class="btn btn-outline-primary btn-sm">Gérer</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Profil</span>
                            <a href="#" class="btn btn-outline-secondary btn-sm">Modifier</a>
                        </li>
                    </ul>
                    <div class="alert alert-info">
                        <strong>Info :</strong> Créez et gérez vos annonces publicitaires sur Cashback Market.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
