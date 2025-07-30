@extends('layouts.app')

@section('title', 'Parrainage')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center">
                    <h1 class="mb-4 text-primary fw-bold">Programme de Parrainage</h1>
                    <p class="lead mb-3">Invitez vos amis à rejoindre Cashback Market et gagnez des récompenses pour chaque inscription validée !</p>
                    <div class="mb-4">
                        <img src="{{ asset('images/parrainage.png') }}" alt="Parrainage" class="img-fluid" style="max-height:180px;">
                    </div>
                    <div class="alert alert-success mb-4">
                        <strong>Comment ça marche ?</strong><br>
                        1. Partagez votre lien de parrainage personnalisé.<br>
                        2. Votre filleul s'inscrit et effectue son premier achat.<br>
                        3. Vous recevez un bonus cashback !
                    </div>
                    <a href="#" class="btn btn-primary btn-lg">Obtenir mon lien de parrainage</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
