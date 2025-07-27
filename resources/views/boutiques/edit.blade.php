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
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="couleur_principale" class="form-label">Couleur principale</label>
                <input type="color" class="form-control form-control-color" id="couleur_principale" name="couleur_principale" value="{{ old('couleur_principale', $boutique->couleur_principale ?? '#F6E7B2') }}">
            </div>
            <div class="col-md-4">
                <label for="couleur_accent" class="form-label">Couleur accent</label>
                <input type="color" class="form-control form-control-color" id="couleur_accent" name="couleur_accent" value="{{ old('couleur_accent', $boutique->couleur_accent ?? '#8B6B5C') }}">
            </div>
            <div class="col-md-4">
                <label for="couleur_texte" class="form-label">Couleur du texte</label>
                <input type="color" class="form-control form-control-color" id="couleur_texte" name="couleur_texte" value="{{ old('couleur_texte', $boutique->couleur_texte ?? '#3B2F2F') }}">
            </div>
        </div>
        <div class="mb-3">
            <label for="site_web" class="form-label">Lien du site web</label>
            <input type="url" class="form-control" id="site_web" name="site_web" value="{{ old('site_web', $boutique->site_web) }}" placeholder="https://www.votreboutique.com">
        </div>
        <div class="mb-3">
            <label for="slides" class="form-label">Images de slide (sélection multiple possible)</label>
            <input type="file" class="form-control" id="slides" name="slides[]" multiple accept="image/*">
            @if(!empty($boutique->slides))
                <div class="mt-2 d-flex flex-wrap gap-2">
                    @foreach($boutique->slides as $slide)
                        <img src="{{ asset('storage/'.$slide) }}" alt="Slide" style="width:80px;height:60px;object-fit:cover;border-radius:0.5rem;">
                    @endforeach
                </div>
            @endif
        </div>
        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="afficher_annee" name="afficher_annee" value="1" {{ old('afficher_annee', $boutique->afficher_annee ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="afficher_annee">Afficher l'année et "Nouveaux produits" sur la page boutique</label>
        </div>
        <div class="mb-3">
            <label for="qr_code" class="form-label">QR code personnalisé (optionnel)</label>
            <input type="url" class="form-control" id="qr_code" name="qr_code" value="{{ old('qr_code', $boutique->qr_code) }}" placeholder="URL de l'image QR code">
            <small class="text-muted">Laisser vide pour générer automatiquement le QR code du lien boutique.</small>
        </div>
        <button type="submit" class="btn btn-cbm">Enregistrer les modifications</button>
    </form>
</div>
@endsection
