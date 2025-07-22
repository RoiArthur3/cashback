@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Gestion des utilisateurs</h2>
    <div class="alert alert-secondary">Liste, création, modification et suppression des comptes utilisateurs.</div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle bg-white">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users ?? [] as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge bg-info">{{ ucfirst($user->role) }}</span></td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">Modifier</a>
                        <a href="#" class="btn btn-sm btn-danger">Supprimer</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="#" class="btn btn-cbm mt-3"><i class="bi bi-plus-circle"></i> Ajouter un utilisateur</a>
</div>
@endsection
