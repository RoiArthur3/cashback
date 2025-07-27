<!-- Section Produits en Promotion -->
<div class="mx-3 mb-4">
    <div class="p-4 rounded-3" style="background: linear-gradient(135deg, #f8fafc, #e2e8f0); border: 1px solid #e2e8f0;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1" style="color: var(--primary-blue);">Promotions Flash</h3>
                <p class="text-muted mb-0">Profitez de réductions exceptionnelles</p>
            </div>
            <a href="#" class="btn btn-outline-primary btn-sm">Voir tout</a>
        </div>
        
        <div class="row g-4">
            @forelse($produitsEnPromo as $produit)
            <div class="col-lg-3 col-md-6">
                <div class="product-card h-100 p-3 rounded-3" style="background: white; border: 1px solid #e2e8f0; transition: all 0.3s ease;">
                    <div class="position-relative mb-3">
                        <img src="{{ $produit->image_url ?? 'https://via.placeholder.com/300' }}" alt="{{ $produit->nom }}" class="img-fluid rounded-3" style="height: 150px; width: 100%; object-fit: cover;">
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-danger">
                                -{{ $produit->pourcentage_reduction }}%
                            </span>
                        </div>
                    </div>
                    <h6 class="fw-bold mb-1">{{ Str::limit($produit->nom, 40) }}</h6>
                    <p class="small text-muted mb-2">{{ $produit->boutique->nom ?? 'Boutique' }}</p>
                    <div class="d-flex align-items-center mb-2">
                        <span class="h5 fw-bold text-danger me-2">{{ number_format($produit->prix_actuel, 2, ',', ' ') }} €</span>
                        <small class="text-decoration-line-through text-muted">{{ number_format($produit->prix, 2, ',', ' ') }} €</small>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-2">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-half text-warning"></i>
                        </div>
                        <small class="text-muted">({{ rand(10, 100) }})</small>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-sm btn-primary">
                            <i class="bi bi-cart-plus me-1"></i> Ajouter
                        </button>
                    </div>
                    @if($produit->date_fin_promotion)
                    <div class="mt-2">
                        <div class="progress" style="height: 5px;">
                            @php
                                $totalHours = now()->diffInHours($produit->date_fin_promotion);
                                $remainingHours = max(0, $totalHours);
                                $progress = min(100, (1 - ($remainingHours / 168)) * 100); // Sur 7 jours
                            @endphp
                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $progress }}%" 
                                 aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <small class="text-muted d-block text-center mt-1">
                            <i class="bi bi-clock-history me-1"></i> 
                            Fini dans {{ $remainingHours }}h
                        </small>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4">
                <i class="bi bi-tag fs-1 text-muted mb-3"></i>
                <h5 class="text-muted">Aucune promotion en cours</h5>
                <p class="text-muted small">Revenez plus tard pour découvrir nos offres spéciales</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
