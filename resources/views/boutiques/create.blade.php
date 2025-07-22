                <div class="mb-3">
                    <label for="modele" class="form-label">Modèle d'affichage <span class="text-danger">*</span></label>
                    <select class="form-select" id="modele" name="modele" required>
                        <option value="">-- Choisir un modèle --</option>
                        <option value="classique" @if(old('modele')=='classique') selected @endif>Classique (sobre, épuré, adapté à tous)</option>
                        <option value="business" @if(old('modele')=='business') selected @endif>Business (professionnel, élégant, adapté aux entreprises)</option>
                        <option value="pro" @if(old('modele')=='pro') selected @endif>Pro (moderne, dynamique, pour boutiques premium)</option>
                    </select>
                    @error('modele')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
@extends('layouts.app')
@section('content')
<style>
    /* Police Roboto pour tout sauf les icônes */
    .form-boutique *:not([class*="bi"]) {
        font-family: 'Roboto', Arial, sans-serif !important;
    }
</style>
<!-- Google Fonts Roboto -->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
<div class="container py-4 form-boutique">
    <h2 class="mb-4">Créer une nouvelle boutique</h2>
    <form action="{{ route('boutiques.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom de la boutique <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nom" name="nom" required value="{{ old('nom') }}">
                </div>
                <div class="mb-3">
                    <label for="categorie" class="form-label">Catégorie</label>
                    <input type="text" class="form-control" id="categorie" name="categorie" value="{{ old('categorie') }}">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="offre" class="form-label">Offre spéciale / Promotion</label>
                    <input type="text" class="form-control" id="offre" name="offre" value="{{ old('offre') }}">
                </div>
                <div class="mb-3">
                    <label for="a_propos" class="form-label">À propos du marchand</label>
                    <textarea class="form-control" id="a_propos" name="a_propos" rows="2">{{ old('a_propos') }}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="livraison" class="form-label">Délais de livraison</label>
                    <input type="text" class="form-control" id="livraison" name="livraison" value="{{ old('livraison') }}">
                </div>
                <div class="mb-3">
                    <label for="zone_livraison" class="form-label">Zones desservies</label>
                    <input type="text" class="form-control" id="zone_livraison" name="zone_livraison" value="{{ old('zone_livraison') }}">
                </div>
                <div class="mb-3">
                    <label for="theme" class="form-label">Thème de la boutique</label>
                    <select class="form-select" id="theme" name="theme">
                        <option value="clair">Clair</option>
                        <option value="sombre">Sombre</option>
                        <option value="coloré">Coloré</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="logo" class="form-label">Logo de la boutique</label>
                    <input type="file" class="form-control" id="logo" name="logo" accept="image/png, image/jpeg, image/jpg, image/gif">
                    <small class="form-text text-muted">PNG, JPG, GIF – max 2 Mo – format carré recommandé (ex : 300x300px)</small>
                </div>
                <div class="mb-3">
                    <label for="slide_images" class="form-label">Images du slide (jusqu'à 5)</label>
                    <input type="file" class="form-control" id="slide_images" name="slide_images[]" accept="image/png, image/jpeg, image/jpg, image/gif" multiple>
                    <small class="form-text text-muted">PNG, JPG, GIF – max 4 Mo/image – format paysage conseillé (ex : 900x400px)</small>
                </div>
                <div class="mb-3">
                    <label for="layout" class="form-label">Disposition de la boutique</label>
                    <select class="form-select" id="layout" name="layout">
                        <option value="choc">Choc (impact visuel, couleurs vives, boutons larges)</option>
                        <option value="fun">Fun (formes arrondies, animations, ambiance ludique)</option>
                        <option value="agressif">Agressif (contrastes forts, typographie marquée, style \"flashy\")</option>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Créer la boutique</button>
    </form>
</div>
@endsection
