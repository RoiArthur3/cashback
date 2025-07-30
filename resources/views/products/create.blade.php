@extends('layouts.app')

@section('title', 'Ajouter un produit')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center">Ajouter un nouveau produit</h1>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 600px;">
        @csrf
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du produit</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="prix" class="form-label">Prix (€)</label>
            <input type="number" name="prix" id="prix" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="cashback" class="form-label">Montant du cashback (€)</label>
            <input type="number" name="cashback" id="cashback" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image du produit</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-success w-100">Ajouter le produit</button>
    </form>
</div>
@endsection
