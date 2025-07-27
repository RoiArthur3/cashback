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
                    <h5 class="mb-0">🛒 Mes commandes - Liste de tous les achats effectués</h5>
                </div>
                <div class="card-body">
                    @if($orders->count() > 0)
                        {{-- Statistiques résumées --}}
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ $orders->count() }}</h4>
                                        <div>Commandes totales</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ number_format($orders->sum('montant'), 0, ',', ' ') }} FCFA</h4>
                                        <div>Montant total</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ number_format($orders->sum('cashback_montant'), 0, ',', ' ') }} FCFA</h4>
                                        <div>Cashback total</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ $orders->where('created_at', '>=', now()->startOfMonth())->count() }}</h4>
                                        <div>Ce mois-ci</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Filtres --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <select class="form-select" id="statusFilter">
                                    <option value="">Tous les statuts</option>
                                    <option value="en_preparation">En préparation</option>
                                    <option value="expedie">Expédié</option>
                                    <option value="livre">Livré</option>
                                    <option value="annule">Annulé</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Rechercher un produit ou une boutique..." id="searchOrders">
                            </div>
                        </div>
                        
                        {{-- Liste détaillée des commandes --}}
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produit / Boutique</th>
                                        <th>Date</th>
                                        <th>Prix payé</th>
                                        <th>Cashback</th>
                                        <th>Statut livraison</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $order->produit->image ?? 'https://via.placeholder.com/60x60?text=P' }}" 
                                                         class="rounded me-3" width="60" height="60" alt="Produit">
                                                    <div>
                                                        <h6 class="mb-1">{{ $order->produit->nom ?? 'Produit supprimé' }}</h6>
                                                        <small class="text-muted">
                                                            <i class="bi bi-shop"></i> {{ $order->boutique->nom ?? 'Boutique inconnue' }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>{{ $order->created_at->format('d/m/Y') }}</div>
                                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ number_format($order->montant, 0, ',', ' ') }} FCFA</div>
                                            </td>
                                            <td>
                                                @if($order->cashback_montant > 0)
                                                    <div class="text-success fw-bold">+{{ number_format($order->cashback_montant, 0, ',', ' ') }} FCFA</div>
                                                    @if($order->statut_cashback == 'valide')
                                                        <small class="badge bg-success">Validé</small>
                                                    @else
                                                        <small class="badge bg-warning">En attente</small>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $statut = $order->statut_livraison ?? 'livre';
                                                    $badgeClass = match($statut) {
                                                        'en_preparation' => 'bg-info',
                                                        'expedie' => 'bg-warning',
                                                        'livre' => 'bg-success',
                                                        'annule' => 'bg-danger',
                                                        default => 'bg-success'
                                                    };
                                                    $statutText = match($statut) {
                                                        'en_preparation' => 'En préparation',
                                                        'expedie' => 'Expédié',
                                                        'livre' => 'Livré',
                                                        'annule' => 'Annulé',
                                                        default => 'Livré'
                                                    };
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $statutText }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group-vertical btn-group-sm" role="group">
                                                    @if($order->produit)
                                                        <a href="{{ route('produits.show', $order->produit->id) }}" 
                                                           class="btn btn-outline-primary btn-sm mb-1">
                                                            <i class="bi bi-eye"></i> Voir produit
                                                        </a>
                                                    @endif
                                                    @if($order->boutique)
                                                        <button class="btn btn-outline-success btn-sm mb-1" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#contactSellerModal" 
                                                                data-order-id="{{ $order->id }}"
                                                                data-seller-name="{{ $order->boutique->nom }}">
                                                            <i class="bi bi-chat-dots"></i> Contacter vendeur
                                                        </button>
                                                    @endif
                                                    <button class="btn btn-outline-secondary btn-sm" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#orderDetailsModal"
                                                            data-order-id="{{ $order->id }}">
                                                        <i class="bi bi-info-circle"></i> Détails
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- Pagination si nécessaire --}}
                        @if($orders->count() > 10)
                            <div class="d-flex justify-content-center mt-4">
                                <nav>
                                    <ul class="pagination">
                                        <li class="page-item"><a class="page-link" href="#">Précédent</a></li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">Suivant</a></li>
                                    </ul>
                                </nav>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-bag fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune commande pour le moment</h5>
                            <p class="text-muted">Découvrez nos produits et passez votre première commande !</p>
                            <a href="{{ route('boutiques.index') }}" class="btn btn-primary">Découvrir les boutiques</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Contacter le vendeur --}}
<div class="modal fade" id="contactSellerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Contacter le vendeur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Boutique</label>
                        <input type="text" class="form-control" id="sellerName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="messageSubject" class="form-label">Sujet</label>
                        <select class="form-select" id="messageSubject">
                            <option value="">Choisir un sujet</option>
                            <option value="livraison">Question sur la livraison</option>
                            <option value="produit">Question sur le produit</option>
                            <option value="retour">Demande de retour/échange</option>
                            <option value="facture">Problème de facturation</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="messageContent" class="form-label">Message</label>
                        <textarea class="form-control" id="messageContent" rows="4" placeholder="Tapez votre message..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Envoyer le message</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Détails commande --}}
<div class="modal fade" id="orderDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails de la commande</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="orderDetailsContent">
                    {{-- Contenu chargé dynamiquement --}}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Gestion des modals
document.addEventListener('DOMContentLoaded', function() {
    // Modal contacter vendeur
    const contactModal = document.getElementById('contactSellerModal');
    contactModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const sellerName = button.getAttribute('data-seller-name');
        document.getElementById('sellerName').value = sellerName;
    });
    
    // Filtres
    document.getElementById('statusFilter').addEventListener('change', function() {
        // Logique de filtrage
    });
    
    document.getElementById('searchOrders').addEventListener('input', function() {
        // Logique de recherche
    });
});
</script>
@endsection
