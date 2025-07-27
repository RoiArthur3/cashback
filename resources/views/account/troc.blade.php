@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3 mb-3">
            @include('account.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-arrow-left-right"></i> Proposer un troc</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                <strong>Comment ça marche ?</strong> Proposez vos objets en échange d'autres produits disponibles sur la plateforme. C'est écologique et économique !
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mb-4">
                        <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#createTrocModal">
                            <i class="bi bi-plus-circle"></i> Proposer un nouveau troc
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Mes propositions de troc</h6>
                </div>
                <div class="card-body">
                    @if($trocs->count() > 0)
                        @foreach($trocs as $troc)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <img src="{{ $troc->image ?? 'https://via.placeholder.com/100x100?text=Objet' }}" class="img-fluid rounded" alt="Objet à troquer">
                                        </div>
                                        <div class="col-md-6">
                                            <h6>{{ $troc->titre }}</h6>
                                            <p class="text-muted mb-1">{{ $troc->description }}</p>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar"></i> Publié le {{ $troc->created_at->format('d/m/Y') }}
                                            </small>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <span class="badge bg-warning">En attente</span>
                                            <div class="mt-2">
                                                <button class="btn btn-outline-primary btn-sm">Voir les offres</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-arrow-left-right fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune proposition de troc</h5>
                            <p class="text-muted">Vous n'avez pas encore proposé d'objets en troc.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Proposer un troc -->
<div class="modal fade" id="createTrocModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Proposer un troc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="trocTitle" class="form-label">Titre de l'objet</label>
                                <input type="text" class="form-control" id="trocTitle" placeholder="Ex: iPhone 12 en bon état">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="trocCategory" class="form-label">Catégorie</label>
                                <select class="form-select" id="trocCategory">
                                    <option value="">Choisir une catégorie</option>
                                    <option value="electronique">Électronique</option>
                                    <option value="vetements">Vêtements</option>
                                    <option value="maison">Maison & Jardin</option>
                                    <option value="sport">Sport & Loisirs</option>
                                    <option value="livres">Livres & Média</option>
                                    <option value="autre">Autre</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="trocDescription" class="form-label">Description détaillée</label>
                        <textarea class="form-control" id="trocDescription" rows="4" placeholder="Décrivez l'état, les caractéristiques, etc."></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="trocValue" class="form-label">Valeur estimée (FCFA)</label>
                                <input type="number" class="form-control" id="trocValue" placeholder="Ex: 50000">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="trocWanted" class="form-label">Recherche en échange</label>
                                <input type="text" class="form-control" id="trocWanted" placeholder="Ex: Ordinateur portable, vélo, etc.">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="trocImages" class="form-label">Photos de l'objet</label>
                        <input type="file" class="form-control" id="trocImages" multiple accept="image/*">
                        <small class="text-muted">Vous pouvez ajouter jusqu'à 5 photos</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Publier le troc</button>
            </div>
        </div>
    </div>
</div>
@endsection
