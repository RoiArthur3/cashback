@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h1 class="mb-4 text-primary">KDO Surprise</h1>
                    <p class="lead mb-4">Participez à notre programme KDO Surprise et tentez de gagner des cadeaux exclusifs à chaque achat !</p>
                    <a href="{{ route('home') }}" class="btn btn-success">Découvrir les offres</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
