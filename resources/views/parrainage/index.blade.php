@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h1 class="mb-4 text-center text-primary">Programme de Parrainage</h1>
                    <p class="lead text-center mb-4">
                        Invitez vos amis à rejoindre Cashback Market et profitez de récompenses exclusives pour chaque parrainage réussi !
                    </p>
                    <div class="text-center mb-4">
                        <a href="{{ route('parrainage.filleuls') }}" class="btn btn-outline-primary mx-2">Voir mes filleuls</a>
                        <a href="{{ route('parrainage.gains') }}" class="btn btn-success mx-2">Voir mes gains</a>
                    </div>
                    <hr>
                    <ul class="list-unstyled mt-4">
                        <li class="mb-2"><i class="bi bi-check-circle text-success"></i> 1. Partagez votre lien de parrainage</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success"></i> 2. Votre filleul s’inscrit et effectue son premier achat</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success"></i> 3. Recevez votre bonus cashback automatiquement</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
