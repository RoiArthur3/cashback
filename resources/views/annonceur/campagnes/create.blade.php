@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Créer une campagne publicitaire</h2>
    <form action="{{ route('annonceur.campagnes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="titre" class="form-label">Titre de la campagne</label>
            <input type="text" class="form-control" id="titre" name="titre" required>
        </div>
        <div class="mb-3">
            <label for="media" class="form-label">Visuel / Média</label>
            <input type="file" class="form-control" id="media" name="media">
        </div>
        <div class="mb-3">
            <label for="lien" class="form-label">Lien cliquable</label>
            <input type="url" class="form-control" id="lien" name="lien" required>
        </div>
        <div class="mb-3">
            <label for="texte_accroche" class="form-label">Texte d'accroche (facultatif)</label>
            <input type="text" class="form-control" id="texte_accroche" name="texte_accroche">
        </div>
        <div class="mb-3">
            <label class="form-label">Ciblage multi-critères</label>
            <div class="row g-2">
                <div class="col-md-4">
                    <select class="form-select" name="ciblage[sexe]">
                        <option value="">Sexe</option>
                        <option value="homme">Homme</option>
                        <option value="femme">Femme</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ciblage[age]" placeholder="Tranche d'âge (ex: 25-35)">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ciblage[localisation]" placeholder="Localisation">
                </div>
            </div>
            <div class="row g-2 mt-2">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ciblage[statut]" placeholder="Statut social">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ciblage[interets]" placeholder="Centres d'intérêt">
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="ciblage[support]">
                        <option value="">Type de support</option>
                        <option value="mobile">Mobile</option>
                        <option value="desktop">Desktop</option>
                        <option value="app">App</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="volume" class="form-label">Volume d'impressions souhaité</label>
            <input type="number" class="form-control" id="volume" name="volume" min="1000" step="1000" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Coût estimé</label>
            <input type="text" class="form-control" id="cout_estime" name="cout_estime" readonly value="Calculé dynamiquement">
        </div>
        <button type="submit" class="btn btn-primary">Créer la campagne</button>
    </form>
</div>
@endsection
