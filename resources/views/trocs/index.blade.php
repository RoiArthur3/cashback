@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Troc entre membres</h2>
    <a href="{{ route('trocs.create') }}" class="btn btn-success mb-3">+ Proposer un troc</a>
    <div class="row">
        @forelse($trocs as $troc)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                @if($troc->image)
                    <img src="{{ Storage::url($troc->image) }}" class="card-img-top" alt="Troc image">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $troc->titre }}</h5>
                    <p class="card-text text-muted small">Par {{ $troc->user->name }}</p>
                    <p class="card-text">{{ Str::limit($troc->description, 80) }}</p>
                    <a href="{{ route('trocs.show', $troc) }}" class="btn btn-primary btn-sm">Voir le détail</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted">Aucun troc pour le moment.</div>
        @endforelse
    </div>
    <div class="mt-4">{{ $trocs->links() }}</div>
</div>
@endsection
