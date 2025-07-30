@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h2 class="mb-4 text-success">Mes gains cumulés</h2>
                    <div class="display-4 mb-3">{{ number_format($gains, 2, ',', ' ') }} €</div>
                    <p class="lead">Ce montant correspond aux gains générés grâce à vos filleuls.</p>
                    <a href="{{ route('parrainage.filleuls') }}" class="btn btn-outline-primary">Voir mes filleuls</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
