@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h2 class="mb-4 text-center text-primary">Mes filleuls</h2>
                    @if($filleuls->isEmpty())
                        <p class="text-center">Vous n'avez pas encore de filleuls.</p>
                    @else
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Date d'inscription</th>
                                    <th>Achats</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($filleuls as $filleul)
                                    <tr>
                                        <td>{{ $filleul->name }}</td>
                                        <td>{{ $filleul->email }}</td>
                                        <td>{{ $filleul->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $filleul->achats->count() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
