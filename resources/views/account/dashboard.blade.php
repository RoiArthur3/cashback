@extends('account.index')
@section('account-content')
<div class="card mb-4">
    <div class="card-body">
        <h4 class="mb-3">Bienvenue, {{ Auth::user()->name }} !</h4>
        <p>Retrouvez ici un aperçu de vos activités : cashbacks, achats, informations personnelles et gestion de votre boutique.</p>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Email :</strong> {{ Auth::user()->email }}</li>
            <li class="list-group-item"><strong>Rôle :</strong> {{ ucfirst(Auth::user()->role) }}</li>
        </ul>
    </div>
</div>
@endsection
