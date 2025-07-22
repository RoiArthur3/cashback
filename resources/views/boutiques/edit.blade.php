@extends('layouts.app')
@section('content')
<div class="container py-4 form-boutique">
    <h2 class="mb-4">Modifier la boutique</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('boutiques.update', $boutique->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom de la boutique <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nom" name="nom" required value="{{ old('nom', $boutique->nom) }}">
                </div>
                <div class="mb-3">
                    <label for="categorie" class="form-label">Catégorie</label>
                    <input type="text" class="form-control" id="categorie" name="categorie" value="{{ old('categorie', $boutique->categorie) }}">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $boutique->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="offre" class="form-label">Offre spéciale / Promotion</label>
                    <input type="text" class="form-control" id="offre" name="offre" value="{{ old('offre', $boutique->offre) }}">
                </div>
                <div class="mb-3">
                    <label for="a_propos" class="form-label">À propos du marchand</label>
                    <textarea class="form-control" id="a_propos" name="a_propos" rows="2">{{ old('a_propos', $boutique->a_propos) }}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="livraison" class="form-label">Délais de livraison</label>
                    <input type="text" class="form-control" id="livraison" name="livraison" value="{{ old('livraison', $boutique->livraison) }}">
                </div>
                <div class="mb-3">
                    <label for="zone_livraison" class="form-label">Zones desservies</label>
                    <input type="text" class="form-control" id="zone_livraison" name="zone_livraison" value="{{ old('zone_livraison', $boutique->zone_livraison) }}">
                </div>
                <div class="mb-3">
                    <label for="theme" class="form-label">Thème de la boutique</label>
                    <select class="form-select" id="theme" name="theme">
                        <option value="clair" @if(old('theme', $boutique->theme)=='clair') selected @endif>Clair</option>
                        <option value="sombre" @if(old('theme', $boutique->theme)=='sombre') selected @endif>Sombre</option>
                        <option value="coloré" @if(old('theme', $boutique->theme)=='coloré') selected @endif>Coloré</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="logo" class="form-label">Logo de la boutique</label>
                    @if($boutique->logo)
                        <div class="mb-2"><img src="{{ asset('storage/'.$boutique->logo) }}" alt="Logo actuel" style="max-width:80px;max-height:80px;"></div>
                    @endif
                    <input type="file" class="form-control" id="logo" name="logo" accept="image/png, image/jpeg, image/jpg, image/gif">
                    <small class="form-text text-muted">PNG, JPG, GIF – max 2 Mo – format carré recommandé (ex : 300x300px)</small>
                </div>
                <div class="mb-3">
                    <label for="slide_images" class="form-label">Images du slide (jusqu'à 5)</label>
                    @if($boutique->slide_images)
                        <div class="mb-2">
                            @foreach(json_decode($boutique->slide_images, true) as $img)
                                <img src="{{ asset('storage/'.$img) }}" alt="Slide" style="max-width:80px;max-height:50px;" class="me-1 mb-1">
                            @endforeach
                        </div>
                    @endif
                    <input type="file" class="form-control" id="slide_images" name="slide_images[]" accept="image/png, image/jpeg, image/jpg, image/gif" multiple>
                    <small class="form-text text-muted">PNG, JPG, GIF – max 4 Mo/image – format paysage conseillé (ex : 900x400px)</small>
                </div>
                <div class="mb-3">
                    <label for="layout" class="form-label">Disposition de la boutique</label>
                    <select class="form-select" id="layout" name="layout">
                        <option value="choc" @if(old('layout', $boutique->layout)=='choc') selected @endif>Choc</option>
                        <option value="fun" @if(old('layout', $boutique->layout)=='fun') selected @endif>Fun</option>
                        <option value="agressif" @if(old('layout', $boutique->layout)=='agressif') selected @endif>Agressif</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="modele" class="form-label">Modèle d'affichage <span class="text-danger">*</span></label>
                    <select class="form-select" id="modele" name="modele" required>
                        <option value="">-- Choisir un modèle --</option>
                        <option value="classique" @if(old('modele', $boutique->modele)=='classique') selected @endif>Classique</option>
                        <option value="business" @if(old('modele', $boutique->modele)=='business') selected @endif>Business</option>
                        <option value="pro" @if(old('modele', $boutique->modele)=='pro') selected @endif>Pro</option>
                    </select>
                    @error('modele')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-cbm">Enregistrer les modifications</button>
    </form>
</div>
@endsection
