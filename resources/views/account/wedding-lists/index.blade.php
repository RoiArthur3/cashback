@extends('layouts.app')

@section('title', 'Mes listes de mariage')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Mes listes de mariage</h1>
    @if($lists->isEmpty())
        <div class="alert alert-info text-center">Vous n'avez pas encore créé de liste de mariage.</div>
        <div class="text-center">
            <a href="{{ route('account.wedding-lists.create') }}" class="btn btn-success">Créer une nouvelle liste</a>
        </div>
    @else
        <div class="row justify-content-center">
            @foreach($lists as $list)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $list->titre ?? 'Liste de mariage' }}</h5>
                            <p class="card-text">{{ $list->description ?? 'Aucune description.' }}</p>
                            <a href="#" class="btn btn-primary">Voir la liste</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
