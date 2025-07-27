@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h1 class="mb-4">Espace Commerçant</h1>
    <h3 class="fw-bold text-danger">👋 Bienvenue, Acheteur</h3>
    <div class="alert alert-success">Bienvenue, vous pouvez gérer vos boutiques et vos offres cashback.</div>
    @if(Auth::check())
        <a href="{{ url('/boutiques/create') }}" class="btn btn-cbm mt-4">Créer ma boutique</a>
    @endif
</div>
@endsection
