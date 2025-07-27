@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3 mb-3">
            @include('account.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">🧧 Mes listes de mariage / souhaits</h5>
                </div>
                <div class="card-body">
                    {{-- Actions rapides --}}
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6>Gestion de vos listes</h6>
                                    <p class="text-muted mb-0">Créez, partagez et suivez vos listes de souhaits</p>
                                </div>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createWeddingListModal">
                                    <i class="bi bi-plus-circle"></i> Créer une nouvelle liste
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Voir mes listes existantes --}}
                    @if($weddingLists->count() > 0)
                        <div class="row">
                            @foreach($weddingLists as $list)
                                <div class="col-md-6 mb-4">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">{{ $list->nom }}</h6>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#shareListModal" data-list-id="{{ $list->id }}"><i class="bi bi-share"></i> Partager</a></li>
                                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#qrCodeModal" data-list-id="{{ $list->id }}"><i class="bi bi-qr-code"></i> QR Code</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Modifier</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash"></i> Supprimer</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text text-muted">{{ $list->description ?? 'Aucune description' }}</p>
                                            
                                            {{-- Statistiques de la liste --}}
                                            <div class="row text-center mb-3">
                                                <div class="col-4">
                                                    <div class="fw-bold text-primary">{{ $list->produits_count ?? 0 }}</div>
                                                    <small class="text-muted">Produits</small>
                                                </div>
                                                <div class="col-4">
                                                    <div class="fw-bold text-success">{{ $list->contributions_count ?? 0 }}</div>
                                                    <small class="text-muted">Contributions</small>
                                                </div>
                                                <div class="col-4">
                                                    <div class="fw-bold text-warning">{{ number_format($list->montant_collecte ?? 0, 0, ',', ' ') }} FCFA</div>
                                                    <small class="text-muted">Collecté</small>
                                                </div>
                                            </div>
                                            
                                            {{-- Barre de progression --}}
                                            @php
                                                $objectif = $list->montant_objectif ?? 100000;
                                                $collecte = $list->montant_collecte ?? 0;
                                                $pourcentage = $objectif > 0 ? min(($collecte / $objectif) * 100, 100) : 0;
                                            @endphp
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <small class="text-muted">Progression</small>
                                                    <small class="text-muted">{{ number_format($pourcentage, 1) }}%</small>
                                                </div>
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-success" style="width: {{ $pourcentage }}%"></div>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex gap-2">
                                                <a href="#" class="btn btn-outline-primary btn-sm flex-fill">Voir la liste</a>
                                                <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#contributionsModal" data-list-id="{{ $list->id }}">
                                                    <i class="bi bi-eye"></i> Suivi
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-light">
                                            <small class="text-muted">
                                                <i class="bi bi-calendar"></i> Créée le {{ $list->created_at->format('d/m/Y') }}
                                                @if($list->date_evenement)
                                                    | Événement le {{ $list->date_evenement->format('d/m/Y') }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-heart fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune liste de mariage créée</h5>
                            <p class="text-muted">Créez votre première liste de mariage pour partager vos souhaits avec vos proches.</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createWeddingListModal">
                                <i class="bi bi-plus-circle"></i> Créer ma première liste
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Créer liste de mariage --}}
<div class="modal fade" id="createWeddingListModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Créer une liste de mariage</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="listName" class="form-label">Nom de la liste</label>
                        <input type="text" class="form-control" id="listName" placeholder="Ex: Notre mariage">
                    </div>
                    <div class="mb-3">
                        <label for="listDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="listDescription" rows="3" placeholder="Décrivez votre liste de mariage..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="weddingDate" class="form-label">Date du mariage</label>
                                <input type="date" class="form-control" id="weddingDate">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="targetAmount" class="form-label">Objectif (FCFA)</label>
                                <input type="number" class="form-control" id="targetAmount" placeholder="100000">
                            </div>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="publicList">
                        <label class="form-check-label" for="publicList">
                            Liste publique (visible par tous)
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Créer la liste</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Partager via lien --}}
<div class="modal fade" id="shareListModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Partager la liste</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Lien de partage</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="shareLink" value="https://cbm.local/liste-mariage/abc123" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('shareLink')">
                            <i class="bi bi-clipboard"></i> Copier
                        </button>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Partager sur les réseaux sociaux</label>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary"><i class="bi bi-facebook"></i> Facebook</button>
                        <button class="btn btn-info"><i class="bi bi-twitter"></i> Twitter</button>
                        <button class="btn btn-success"><i class="bi bi-whatsapp"></i> WhatsApp</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal QR Code --}}
<div class="modal fade" id="qrCodeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">QR Code de la liste</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <div id="qrcode" class="d-flex justify-content-center">
                        {{-- QR Code généré dynamiquement --}}
                        <div class="bg-light border" style="width: 200px; height: 200px; display: flex; align-items: center; justify-content: center;">
                            <span class="text-muted">QR Code</span>
                        </div>
                    </div>
                </div>
                <p class="text-muted">Scannez ce QR code pour accéder directement à la liste</p>
                <button class="btn btn-outline-primary" onclick="downloadQRCode()">
                    <i class="bi bi-download"></i> Télécharger
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Suivi des contributions --}}
<div class="modal fade" id="contributionsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Suivi des contributions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <h4>5</h4>
                                <div>Contributeurs</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h4>75 000 FCFA</h4>
                                <div>Collecté</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <h4>75%</h4>
                                <div>Objectif atteint</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h6>Dernières contributions</h6>
                <div class="list-group">
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Marie Dupont</strong><br>
                                <small class="text-muted">Service à thé en porcelaine</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-success">15 000 FCFA</div>
                                <small class="text-muted">Il y a 2 jours</small>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Pierre Martin</strong><br>
                                <small class="text-muted">Contribution libre</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-success">25 000 FCFA</div>
                                <small class="text-muted">Il y a 5 jours</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    element.select();
    document.execCommand('copy');
    // Afficher une notification de succès
}

function downloadQRCode() {
    // Logique pour télécharger le QR code
}
</script>
@endsection
