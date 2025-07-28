@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Mon Profil</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3 text-center">
                        <i class="fas fa-user-circle fa-5x text-secondary"></i>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Nom :</strong> {{ $user->name }}</li>
                        <li class="list-group-item"><strong>Email :</strong> {{ $user->email }}</li>
                        <li class="list-group-item"><strong>Date d'inscription :</strong> {{ $user->created_at->format('d/m/Y') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
