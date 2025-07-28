@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Proposer un nouveau troc</h2>
    <form action="{{ route('trocs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" class="form-control" id="titre" name="titre" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image (optionnelle)</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary">Publier le troc</button>
    </form>
</div>
@endsection
