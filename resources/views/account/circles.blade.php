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
                    <h5 class="mb-0"><i class="bi bi-people"></i> Mes cercles</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                <strong>Qu'est-ce qu'un cercle ?</strong> Créez des groupes avec vos proches pour partager des achats groupés, des listes de souhaits communes et bénéficier d'avantages exclusifs !
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <i class="bi bi-people fs-1 mb-2"></i>
                                    <h4>{{ $circles->count() }}</h4>
                                    <div>Cercles rejoints</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <i class="bi bi-person-plus fs-1 mb-2"></i>
                                    <h4>{{ $circles->where('creator_id', auth()->id())->count() }}</h4>
                                    <div>Cercles créés</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <i class="bi bi-gift fs-1 mb-2"></i>
                                    <h4>0</h4>
                                    <div>Achats groupés</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mb-4">
                        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#createCircleModal">
                            <i class="bi bi-plus-circle"></i> Créer un cercle
                        </button>
                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#joinCircleModal">
                            <i class="bi bi-person-plus"></i> Rejoindre un cercle
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Mes cercles actifs</h6>
                </div>
                <div class="card-body">
                    @if($circles->count() > 0)
                        <div class="row">
                            @foreach($circles as $circle)
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                                    <i class="bi bi-people text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $circle->nom }}</h6>
                                                    <small class="text-muted">{{ $circle->membres_count ?? 0 }} membres</small>
                                                </div>
                                            </div>
                                            <p class="text-muted mb-3">{{ $circle->description }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    @if($circle->creator_id == auth()->id())
                                                        <span class="badge bg-success">Créateur</span>
                                                    @else
                                                        <span class="badge bg-info">Membre</span>
                                                    @endif
                                                </small>
                                                <div>
                                                    <a href="#" class="btn btn-outline-primary btn-sm">Voir</a>
                                                    @if($circle->creator_id == auth()->id())
                                                        <a href="#" class="btn btn-outline-secondary btn-sm">Gérer</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-people fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun cercle rejoint</h5>
                            <p class="text-muted">Créez votre premier cercle ou rejoignez celui de vos proches pour commencer à partager !</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Créer un cercle -->
<div class="modal fade" id="createCircleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Créer un cercle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="circleName" class="form-label">Nom du cercle</label>
                        <input type="text" class="form-control" id="circleName" placeholder="Ex: Famille Martin, Amis de promo...">
                    </div>
                    <div class="mb-3">
                        <label for="circleDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="circleDescription" rows="3" placeholder="Décrivez l'objectif de votre cercle..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="circleType" class="form-label">Type de cercle</label>
                        <select class="form-select" id="circleType">
                            <option value="famille">Famille</option>
                            <option value="amis">Amis</option>
                            <option value="collegues">Collègues</option>
                            <option value="voisins">Voisins</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="circlePrivate" checked>
                        <label class="form-check-label" for="circlePrivate">
                            Cercle privé (sur invitation uniquement)
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Créer le cercle</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Rejoindre un cercle -->
<div class="modal fade" id="joinCircleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejoindre un cercle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="circleCode" class="form-label">Code d'invitation</label>
                        <input type="text" class="form-control" id="circleCode" placeholder="Ex: ABC123">
                        <small class="text-muted">Demandez le code d'invitation au créateur du cercle</small>
                    </div>
                    <div class="text-center">
                        <p class="text-muted">ou</p>
                    </div>
                    <div class="mb-3">
                        <label for="circleSearch" class="form-label">Rechercher un cercle public</label>
                        <input type="text" class="form-control" id="circleSearch" placeholder="Nom du cercle...">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Rejoindre</button>
            </div>
        </div>
    </div>
</div>
@endsection
