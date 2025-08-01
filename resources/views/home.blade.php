@extends('layouts.app')

@section('content')
@if(Auth::check())
<!-- Espace Cashback connecté -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-5 fw-bold mb-4 animate__animated animate__fadeInDown">Votre cashback, vos envies, vos achats !</h1>
            <p class="lead mb-4">Profitez d'offres exclusives, suivez vos commandes et gagnez du cash à chaque instant sur CabaCaba.</p>
        </div>
    </div>
</div>
@else
<!-- Présentation CabaCaba pour visiteurs -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-5 fw-bold mb-4 animate__animated animate__fadeInDown">CabaCaba</h1>
            <p class="lead mb-4">Du cash en retour sur chaque achat</p>
            <div class="alert alert-info rounded-4 mb-4">
                <strong>Comment ça marche&nbsp;?</strong><br>
                1. Inscrivez-vous gratuitement<br>
                2. Achetez dans vos boutiques préférées<br>
                3. Recevez du cashback sur chaque achat<br>
                4. Invitez vos amis et gagnez sur leurs achats
            </div>
            <a href="{{ route('register') }}" class="btn btn-cbm btn-lg px-4">Inscription gratuite</a>
            <a href="{{ route('boutiques.index') }}" class="btn btn-outline-primary btn-lg px-4 ms-2">Voir les boutiques</a>
        </div>
    </div>
    <!-- Types de compte -->
    <div class="row justify-content-center mt-5">
        <div class="col-md-10">
            <h2 class="fw-bold mb-4 text-center">Types de compte sur CabaCaba</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0 rounded-4 text-center">
                        <div class="card-body">
                            <i class="bi bi-person-badge display-5 text-primary mb-2"></i>
                            <h5 class="fw-bold">Acheteur simple</h5>
                            <p class="text-muted">Achetez, recevez du cashback et profitez des offres partenaires.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0 rounded-4 text-center">
                        <div class="card-body">
                            <i class="bi bi-briefcase display-5 text-success mb-2"></i>
                            <h5 class="fw-bold">Commercial freelance</h5>
                            <p class="text-muted">Recommandez la plateforme, parrainez et gagnez sur les achats de vos contacts.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0 rounded-4 text-center">
                        <div class="card-body">
                            <i class="bi bi-megaphone display-5 text-warning mb-2"></i>
                            <h5 class="fw-bold">Annonceur</h5>
                            <p class="text-muted">Proposez vos produits ou services et touchez de nouveaux clients.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0 rounded-4 text-center">
                        <div class="card-body">
                            <i class="bi bi-shop-window display-5 text-info mb-2"></i>
                            <h5 class="fw-bold">Commerçant Partenaire</h5>
                            <p class="text-muted">Mettez en avant vos produits et offrez du cashback pour attirer et fidéliser de nouveaux clients.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
