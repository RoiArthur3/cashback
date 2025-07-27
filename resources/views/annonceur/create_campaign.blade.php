@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Créer une campagne</h2>
    <form method="POST" action="#">
        @csrf
        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" class="form-control" id="titre" name="titre" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-control" id="type" name="type">
                <option value="annonce">Annonce</option>
                <option value="deal">Deal sponsorisé</option>
                <option value="banniere">Bannière</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="cible" class="form-label">Cible</label>
            <input type="text" class="form-control" id="cible" name="cible" placeholder="Ville, âge, catégorie...">
        </div>
        <div class="mb-3">
            <label for="date_debut" class="form-label">Date début</label>
            <input type="date" class="form-control" id="date_debut" name="date_debut">
        </div>
        <div class="mb-3">
            <label for="date_fin" class="form-label">Date fin</label>
            <input type="date" class="form-control" id="date_fin" name="date_fin">
        </div>
        <div class="mb-3">
            <label for="budget" class="form-label">Budget</label>
            <input type="number" class="form-control" id="budget" name="budget">
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>
@endsection
