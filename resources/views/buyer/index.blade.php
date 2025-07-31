@extends('layouts.app')

@section('content')
@include('buyer.partials.content')
<style>



.category-icon:hover {
    transform: scale(1.1);
}

.product-card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.flash-sale {
    background: linear-gradient(135deg, var(--light-blue) 0%, var(--secondary-blue) 100%);
    border-radius: 20px;
    color: white;
    position: relative;
    overflow: hidden;
}

.countdown-item {
    background: rgba(255,255,255,0.2);
    border-radius: 10px;
    padding: 0.5rem;
    margin: 0 0.25rem;
    min-width: 60px;
    text-align: center;
}

.notification-card {
    border-left: 4px solid var(--secondary-blue);
    background: linear-gradient(90deg, var(--bg-blue) 0%, #ffffff 100%);
    border-radius: 0 10px 10px 0;
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>

<div class="container-fluid px-0">
    <!-- Hero Section -->
    <div class="hero-section mx-3 mb-4 p-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ auth()->user()->profile_picture ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=ffffff&color=1e40af' }}" alt="Photo de profil" class="rounded-circle me-3" width="60" height="60">
                    <div>
                        <h1 class="mb-1 fw-bold">Bienvenue {{ auth()->user()->name }} ! 👋</h1>
                        <p class="mb-0 opacity-75">Découvrez vos cashbacks et les meilleures offres</p>
                    </div>
                </div>

                <!-- Statistiques Cashback -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 rounded-3" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px);">
                            <div class="me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(34, 197, 94, 0.2);">
                                    <i class="bi bi-check-circle-fill fs-3 text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="mb-1 fw-bold text-white">{{ number_format($cashback_valide ?? 8500, 0, ',', ' ') }} FCFA</h3>
                                <p class="mb-1 opacity-75">Cashback Validé</p>

                                <!-- Jauge de progression jaune -->
                                <div class="progress mb-1" style="height: 6px; background: rgba(255,255,255,0.2);">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: {{ min(100, (($cashback_valide ?? 8500) / 10000) * 100) }}%; background: linear-gradient(90deg, #fbbf24, #f59e0b);"
                                         aria-valuenow="{{ min(100, (($cashback_valide ?? 8500) / 10000) * 100) }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                    </div>
                                </div>

                                <small class="opacity-60">{{ number_format(10000 - ($cashback_valide ?? 8500), 0, ',', ' ') }} FCFA pour atteindre 10,000</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 rounded-3" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px);">
                            <div class="me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(251, 191, 36, 0.2);">
                                    <i class="bi bi-hourglass-split fs-3 text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold text-white">{{ number_format($cashback_en_attente ?? 1200, 0, ',', ' ') }} FCFA</h3>
                                <p class="mb-0 opacity-75">Cashback en Attente</p>
                                <small class="opacity-60">À valider sous 48h</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="col-lg-4 text-center">
                <div class="p-4">
                    <h5 class="mb-3 fw-bold text-white">Mon QR Code</h5>
                    <div class="mb-3">
                        <!-- Génération du QR Code avec l'ID utilisateur -->
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode('CASHBACK_USER_' . auth()->user()->id . '_' . auth()->user()->email) }}"
                             alt="QR Code utilisateur"
                             class="img-fluid rounded-3 shadow-sm"
                             style="max-width: 150px;">
                    </div>
                    <p class="small mb-2 text-white opacity-75">Scannez pour partager</p>
                    <p class="small text-white opacity-60 mb-0">ID: #{{ str_pad(auth()->user()->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <button class="btn btn-sm mt-2" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);">
                        <i class="bi bi-download me-1"></i>Télécharger
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3 Colonnes : Catégories, Meilleure Boutique, Meilleur Produit -->
    <div class="mx-3 mb-4">
        <div class="row g-4">
            <!-- Colonne 1: Catégories -->
            <div class="col-lg-4">
                <div class="section-card h-100 p-4 rounded-3" style="background: linear-gradient(135deg, #f8fafc, #e2e8f0); border: 1px solid #e2e8f0;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle me-3" style="background: var(--primary-blue); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-grid-3x3-gap-fill fs-4 text-white"></i>
                        </div>
                        <h5 class="mb-0 fw-bold" style="color: var(--primary-blue);">Catégories</h5>
                    </div>

                    <div class="categories-grid">
                        <div class="row g-2">
                            <div class="col-4">
                                <div class="category-mini text-center p-2 rounded-3" style="background: rgba(30, 64, 175, 0.1); transition: all 0.3s ease;">
                                    <i class="bi bi-phone fs-5 mb-1" style="color: var(--primary-blue);"></i>
                                    <div class="fw-bold" style="font-size: 0.75rem;">Électronique</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="category-mini text-center p-2 rounded-3" style="background: rgba(30, 64, 175, 0.1); transition: all 0.3s ease;">
                                    <i class="bi bi-bag fs-5 mb-1" style="color: var(--primary-blue);"></i>
                                    <div class="fw-bold" style="font-size: 0.75rem;">Mode</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="category-mini text-center p-2 rounded-3" style="background: rgba(30, 64, 175, 0.1); transition: all 0.3s ease;">
                                    <i class="bi bi-house fs-5 mb-1" style="color: var(--primary-blue);"></i>
                                    <div class="fw-bold" style="font-size: 0.75rem;">Maison</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="category-mini text-center p-2 rounded-3" style="background: rgba(30, 64, 175, 0.1); transition: all 0.3s ease;">
                                    <i class="bi bi-heart fs-5 mb-1" style="color: var(--primary-blue);"></i>
                                    <div class="fw-bold" style="font-size: 0.75rem;">Beauté</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="category-mini text-center p-2 rounded-3" style="background: rgba(30, 64, 175, 0.1); transition: all 0.3s ease;">
                                    <i class="bi bi-controller fs-5 mb-1" style="color: var(--primary-blue);"></i>
                                    <div class="fw-bold" style="font-size: 0.75rem;">Gaming</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="category-mini text-center p-2 rounded-3" style="background: rgba(30, 64, 175, 0.1); transition: all 0.3s ease;">
                                    <i class="bi bi-bicycle fs-5 mb-1" style="color: var(--primary-blue);"></i>
                                    <div class="fw-bold" style="font-size: 0.75rem;">Sport</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="category-mini text-center p-2 rounded-3" style="background: rgba(30, 64, 175, 0.1); transition: all 0.3s ease;">
                                    <i class="bi bi-book fs-5 mb-1" style="color: var(--primary-blue);"></i>
                                    <div class="fw-bold" style="font-size: 0.75rem;">Livres</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="category-mini text-center p-2 rounded-3" style="background: rgba(30, 64, 175, 0.1); transition: all 0.3s ease;">
                                    <i class="bi bi-car-front fs-5 mb-1" style="color: var(--primary-blue);"></i>
                                    <div class="fw-bold" style="font-size: 0.75rem;">Auto</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="category-mini text-center p-2 rounded-3" style="background: rgba(30, 64, 175, 0.1); transition: all 0.3s ease;">
                                    <i class="bi bi-plus-circle fs-5 mb-1" style="color: var(--primary-blue);"></i>
                                    <div class="fw-bold" style="font-size: 0.75rem;">Voir plus</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne 2: Boutique avec le plus grand cashback -->
            <div class="col-lg-4">
                <div class="section-card h-100 p-4 rounded-3" style="background: linear-gradient(135deg, #f8fafc, #e2e8f0); border: 1px solid #e2e8f0;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle me-3" style="background: var(--secondary-blue); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-shop fs-4 text-white"></i>
                        </div>
                        <h5 class="mb-0 fw-bold" style="color: var(--primary-blue);">Top Boutique</h5>
                    </div>

                    <div class="top-shop-card">
                        <div class="d-flex align-items-center mb-3">
                            <div class="shop-logo me-3">
                                <img src="https://ui-avatars.com/api/?name=TechStore&background=1e40af&color=ffffff&size=60"
                                     alt="TechStore" class="rounded-circle shadow-sm" width="60" height="60">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold">TechStore Pro</h6>
                                <p class="mb-0 small text-muted">Électronique & High-Tech</p>
                                <div class="mt-1">
                                    <span class="badge bg-success">Partenaire Officiel</span>
                                </div>
                            </div>
                        </div>

                        <div class="cashback-highlight text-center p-3 rounded-3 mb-3" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));">
                            <div class="text-white">
                                <h3 class="mb-1 fw-bold">15%</h3>
                                <small>Cashback Maximum</small>
                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-sm" style="background: var(--primary-blue); color: white; border: none;">
                                <i class="bi bi-arrow-right me-1"></i>Voir la boutique
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne 3: Produit avec le plus grand cashback -->
            <div class="col-lg-4">
                <div class="section-card h-100 p-4 rounded-3" style="background: linear-gradient(135deg, #f8fafc, #e2e8f0); border: 1px solid #e2e8f0;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle me-3" style="background: var(--success-green); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-star-fill fs-4 text-white"></i>
                        </div>
                        <h5 class="mb-0 fw-bold" style="color: var(--primary-blue);">Top Produit</h5>
                    </div>

                    <div class="top-product-card">
                        <div class="product-image mb-3 text-center">
                            <img src="https://via.placeholder.com/120x120/1e40af/ffffff?text=iPhone"
                                 alt="iPhone 15 Pro" class="rounded-3 shadow-sm" style="max-width: 120px;">
                        </div>

                        <div class="text-center mb-3">
                            <h6 class="mb-1 fw-bold">iPhone 15 Pro Max</h6>
                            <p class="mb-0 small text-muted">Apple Store Officiel</p>
                            <div class="mt-2">
                                <span class="badge" style="background: var(--success-green);">En stock</span>
                                <span class="badge bg-warning text-dark ms-1">Populaire</span>
                            </div>
                        </div>

                        <div class="cashback-highlight text-center p-3 rounded-3 mb-3" style="background: linear-gradient(135deg, var(--success-green), #10b981);">
                            <div class="text-white">
                                <h3 class="mb-1 fw-bold">25,000</h3>
                                <small>FCFA Cashback</small>
                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-sm" style="background: var(--success-green); color: white; border: none;">
                                <i class="bi bi-cart-plus me-1"></i>Acheter maintenant
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cash & Deals Section -->
    <div class="mx-3 mb-4">
        <div class="cash-deals-section p-4 rounded-3" style="background: linear-gradient(135deg, #fbbf24, #f59e0b, #d97706); position: relative; overflow: hidden;">
            <!-- Motifs décoratifs -->
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%; opacity: 0.5;"></div>
            <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%; opacity: 0.3;"></div>

            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3" style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 50%; backdrop-filter: blur(10px);">
                            <i class="bi bi-cash-coin fs-1 text-white"></i>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1 text-white">OFFRES EXCLUSIVES</h2>
                            <p class="mb-0 text-white opacity-90">Découvrez nos meilleures promotions cashback</p>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="deal-card p-3 rounded-3 text-center" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
                                <div class="fw-bold" style="color: #d97706; font-size: 1.5rem;">20%</div>
                                <small class="text-muted">Cashback Électronique</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="deal-card p-3 rounded-3 text-center" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
                                <div class="fw-bold" style="color: #d97706; font-size: 1.5rem;">15%</div>
                                <small class="text-muted">Cashback Mode</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button class="btn btn-light btn-lg fw-bold flex-fill" style="color: #d97706; border: 2px solid rgba(255,255,255,0.3);">
                            <i class="bi bi-eye me-2"></i>Voir les offres
                        </button>
                        <button class="btn btn-lg fw-bold" style="background: rgba(255,255,255,0.2); color: white; border: 2px solid rgba(255,255,255,0.3); backdrop-filter: blur(10px);">
                            <i class="bi bi-heart me-2"></i>Favoris
                        </button>
                    </div>
                </div>

                <div class="col-lg-6 text-center">
                    <div class="deals-highlight">
                        <div class="mb-3">
                            <div class="display-1" style="filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));">💰</div>
                        </div>

                        <div class="deals-stats">
                            <div class="row g-2">
                                <div class="col-4">
                                    <div class="stat-item p-2 rounded-3" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
                                        <div class="fw-bold text-white fs-5">150+</div>
                                        <small class="text-white opacity-75">Deals actifs</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item p-2 rounded-3" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
                                        <div class="fw-bold text-white fs-5">50%</div>
                                        <small class="text-white opacity-75">Cashback max</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item p-2 rounded-3" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
                                        <div class="fw-bold text-white fs-5">24h</div>
                                        <small class="text-white opacity-75">Validation</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <h4 class="fw-bold text-white mb-2">Maximisez vos gains cashback</h4>
                            <p class="text-white opacity-75 mb-0">Profitez de nos offres limitées dans le temps</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Produits les plus vendus -->
    <div class="mx-3 mb-4">
        <div class="p-4 rounded-3" style="background: linear-gradient(135deg, #f8fafc, #e2e8f0); border: 1px solid #e2e8f0;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1" style="color: var(--primary-blue);">Produits les plus vendus</h3>
                    <p class="text-muted mb-0">Découvrez les favoris de nos clients</p>
                </div>
                <a href="#" class="btn btn-outline-primary btn-sm">Voir tout</a>
            </div>

            <div class="row g-3">
                @for($i = 1; $i <= 12; $i++)
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="product-mini-card h-100 p-3 rounded-3 text-center" style="background: white; border: 1px solid #e2e8f0; transition: all 0.3s ease;">
                        <div class="position-relative mb-2">
                            <img src="https://via.placeholder.com/80x80/1e40af/ffffff?text=P{{ $i }}"
                                 alt="Produit {{ $i }}"
                                 class="img-fluid rounded-2"
                                 style="width: 80px; height: 80px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0" style="transform: translate(25%, -25%);">
                                <span class="badge bg-danger" style="font-size: 0.6rem;">-{{ rand(10, 30) }}%</span>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-1" style="font-size: 0.8rem; line-height: 1.2;">Produit {{ $i }}</h6>
                        <p class="text-muted mb-2" style="font-size: 0.7rem;">Boutique {{ chr(64 + $i) }}</p>

                        <div class="mb-2">
                            <div class="fw-bold" style="color: var(--primary-blue); font-size: 0.85rem;">{{ number_format(rand(15000, 50000), 0, ',', ' ') }} FCFA</div>
                            <small class="text-success" style="font-size: 0.7rem;">+{{ rand(5, 20) }}% cashback</small>
                        </div>

                        <div class="d-flex gap-1">
                            <button class="btn btn-sm flex-fill" style="background: var(--primary-blue); color: white; font-size: 0.7rem; padding: 0.25rem 0.5rem;">
                                <i class="bi bi-cart-plus me-1"></i>Acheter
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" style="font-size: 0.7rem; padding: 0.25rem 0.5rem;">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>

                        <div class="mt-2">
                            <small class="text-muted" style="font-size: 0.65rem;">{{ rand(50, 500) }} vendus</small>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Section Cash and Deals + Publicité -->
    <div class="mx-3 mb-4">
        <style>
            @keyframes troc-swing {
                0%, 100% { transform: rotate(0deg); }
                25% { transform: rotate(-15deg); }
                75% { transform: rotate(15deg); }
            }
            @keyframes flash-blink {
                0%, 50%, 100% { opacity: 1; }
                25%, 75% { opacity: 0.3; }
            }
            @keyframes gift-bounce {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-8px); }
            }
            @keyframes percent-spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            @keyframes icon-glow {
                0%, 100% { box-shadow: 0 0 10px rgba(255,255,255,0.3); }
                50% { box-shadow: 0 0 20px rgba(255,255,255,0.6), 0 0 30px rgba(255,255,255,0.4); }
            }
            .troc-icon {
                animation: troc-swing 2s ease-in-out infinite;
            }
            .flash-icon {
                animation: flash-blink 1.5s ease-in-out infinite;
            }
            .gift-icon {
                animation: gift-bounce 2.5s ease-in-out infinite;
            }
            .percent-icon {
                animation: percent-spin 4s linear infinite;
            }
            .deal-icon-container {
                animation: icon-glow 3s ease-in-out infinite;
                transition: all 0.3s ease;
            }
            .deal-icon-container:hover {
                transform: scale(1.1);
                animation-play-state: paused;
            }
        </style>

        <div class="row g-4">
            <!-- Colonne 1: Cash and Deals (plus grande) -->
            <div class="col-lg-8">
                <div class="p-4 rounded-3" style="background: linear-gradient(135deg, #f8fafc, #e2e8f0); border: 1px solid #e2e8f0;">
                    <div class="mb-4">
                        <h3 class="fw-bold mb-1" style="color: var(--primary-blue);">Cash & Deals</h3>
                        <p class="text-muted mb-0">Toutes nos offres spéciales en un coup d'œil</p>
                    </div>

                    <div class="row g-3">
                        <!-- Troc - Violet -->
                        <div class="col-md-6">
                            <div class="deal-category-card p-4 rounded-3 h-100" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; transition: all 0.3s ease;">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3 deal-icon-container" style="background: rgba(255,255,255,0.2); padding: 12px; border-radius: 50%;">
                                        <i class="bi bi-arrow-left-right fs-4 text-white troc-icon"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Troc</h5>
                                        <small class="opacity-75">Échangez vos produits</small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold fs-5">{{ rand(15, 50) }} offres</div>
                                        <small class="opacity-75">Disponibles</small>
                                    </div>
                                    <button class="btn btn-light btn-sm fw-bold" style="color: #7c3aed;">
                                        <i class="bi bi-arrow-right me-1"></i>Voir
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Ventes Flash - Rouge -->
                        <div class="col-md-6">
                            <div class="deal-category-card p-4 rounded-3 h-100" style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; transition: all 0.3s ease;">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3 deal-icon-container" style="background: rgba(255,255,255,0.2); padding: 12px; border-radius: 50%;">
                                        <i class="bi bi-lightning-charge-fill fs-4 text-white flash-icon"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Ventes Flash</h5>
                                        <small class="opacity-75">Offres limitées</small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold fs-5">{{ rand(5, 25) }} offres</div>
                                        <small class="opacity-75">Se terminent bientôt</small>
                                    </div>
                                    <button class="btn btn-light btn-sm fw-bold" style="color: #dc2626;">
                                        <i class="bi bi-arrow-right me-1"></i>Voir
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Bons Plans - Vert -->
                        <div class="col-md-6">
                            <div class="deal-category-card p-4 rounded-3 h-100" style="background: linear-gradient(135deg, #10b981, #059669); color: white; transition: all 0.3s ease;">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3 deal-icon-container" style="background: rgba(255,255,255,0.2); padding: 12px; border-radius: 50%;">
                                        <i class="bi bi-gift fs-4 text-white gift-icon"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Bons Plans</h5>
                                        <small class="opacity-75">Meilleurs prix</small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold fs-5">{{ rand(30, 80) }} offres</div>
                                        <small class="opacity-75">Sélectionnées</small>
                                    </div>
                                    <button class="btn btn-light btn-sm fw-bold" style="color: #059669;">
                                        <i class="bi bi-arrow-right me-1"></i>Voir
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Deals - Orange -->
                        <div class="col-md-6">
                            <div class="deal-category-card p-4 rounded-3 h-100" style="background: linear-gradient(135deg, #f97316, #ea580c); color: white; transition: all 0.3s ease;">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3 deal-icon-container" style="background: rgba(255,255,255,0.2); padding: 12px; border-radius: 50%;">
                                        <i class="bi bi-percent fs-4 text-white percent-icon"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Deals</h5>
                                        <small class="opacity-75">Réductions exclusives</small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold fs-5">{{ rand(20, 60) }} offres</div>
                                        <small class="opacity-75">Jusqu'à -70%</small>
                                    </div>
                                    <button class="btn btn-light btn-sm fw-bold" style="color: #ea580c;">
                                        <i class="bi bi-arrow-right me-1"></i>Voir
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne 2: Image Publicitaire (plus petite) -->
            <div class="col-lg-4">
                <div class="h-100 rounded-3 overflow-hidden" style="background: linear-gradient(135deg, #667eea, #764ba2); position: relative;">
                    <div class="p-4 h-100 d-flex flex-column justify-content-center text-center text-white">
                        <!-- Image publicitaire -->
                        <div class="mb-3">
                            <img src="https://via.placeholder.com/200x150/667eea/ffffff?text=PROMO"
                                 alt="Publicité"
                                 class="img-fluid rounded-3 shadow-sm"
                                 style="max-width: 200px;">
                        </div>

                        <h4 class="fw-bold mb-2">Offre Spéciale</h4>
                        <p class="mb-3 opacity-75">Jusqu'à 50% de cashback sur une sélection de produits</p>

                        <div class="mb-3">
                            <div class="fw-bold fs-4">-50%</div>
                            <small class="opacity-75">Cashback maximum</small>
                        </div>

                        <button class="btn btn-light btn-lg fw-bold" style="color: #667eea;">
                            <i class="bi bi-arrow-right me-2"></i>Profiter de l'offre
                        </button>

                        <!-- Motifs décoratifs -->
                        <div style="position: absolute; top: 10px; right: 10px; width: 60px; height: 60px; background: rgba(255,255,255,0.1); border-radius: 50%; opacity: 0.5;"></div>
                        <div style="position: absolute; bottom: 10px; left: 10px; width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; opacity: 0.3;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Nouvelles Boutiques -->
    <div class="mx-3 mb-4">
        <div class="p-4 rounded-3" style="background: linear-gradient(135deg, #f8fafc, #e2e8f0); border: 1px solid #e2e8f0;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1" style="color: var(--primary-blue);">Nouvelles Boutiques</h3>
                    <p class="text-muted mb-0">Découvrez les dernières boutiques partenaires</p>
                </div>
                <a href="#" class="btn btn-outline-primary btn-sm">Voir toutes les boutiques</a>
            </div>

            <div class="row g-4">
                @for($i = 1; $i <= 6; $i++)
                <div class="col-lg-4 col-md-6">
                    <div class="boutique-card h-100 p-4 rounded-3 text-center" style="background: white; border: 1px solid #e2e8f0; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <!-- Badge "Nouveau" -->
                        <div class="position-relative mb-3">
                            <div class="position-absolute top-0 end-0" style="transform: translate(25%, -25%);">
                                <span class="badge bg-success" style="font-size: 0.7rem;">Nouveau</span>
                            </div>

                            <!-- Logo de la boutique -->
                            <div class="mb-3">
                                <img src="https://ui-avatars.com/api/?name=Boutique+{{ $i }}&background={{ ['1e40af', 'f59e0b', '10b981', 'ef4444', '8b5cf6', 'f97316'][($i-1) % 6] }}&color=ffffff&size=80"
                                     alt="Boutique {{ $i }}"
                                     class="rounded-circle shadow-sm"
                                     width="80"
                                     height="80">
                            </div>
                        </div>

                        <h5 class="fw-bold mb-2">{{ ['TechWorld', 'FashionHub', 'HomeDecor', 'SportZone', 'BeautyShop', 'BookStore'][$i-1] }}</h5>
                        <p class="text-muted mb-3" style="font-size: 0.9rem;">{{ ['Électronique & High-Tech', 'Mode & Accessoires', 'Maison & Décoration', 'Sport & Fitness', 'Beauté & Cosmétiques', 'Livres & Culture'][$i-1] }}</p>

                        <!-- Statistiques de la boutique -->
                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <div class="stat-mini p-2 rounded-2" style="background: rgba(30, 64, 175, 0.1);">
                                    <div class="fw-bold" style="color: var(--primary-blue); font-size: 0.9rem;">{{ rand(5, 20) }}%</div>
                                    <small class="text-muted" style="font-size: 0.7rem;">Cashback</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-mini p-2 rounded-2" style="background: rgba(16, 185, 129, 0.1);">
                                    <div class="fw-bold" style="color: #10b981; font-size: 0.9rem;">{{ rand(50, 500) }}</div>
                                    <small class="text-muted" style="font-size: 0.7rem;">Produits</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-mini p-2 rounded-2" style="background: rgba(251, 191, 36, 0.1);">
                                    <div class="fw-bold" style="color: #fbbf24; font-size: 0.9rem;">{{ number_format(rand(1, 10), 1) }}</div>
                                    <small class="text-muted" style="font-size: 0.7rem;">Note</small>
                                </div>
                            </div>
                        </div>

                        <!-- Offre spéciale -->
                        <div class="mb-3 p-2 rounded-2" style="background: linear-gradient(135deg, rgba(251, 191, 36, 0.1), rgba(245, 158, 11, 0.1));">
                            <small class="fw-bold" style="color: #d97706;">🎉 Offre de lancement : Cashback doublé !</small>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm flex-fill" style="background: var(--primary-blue); color: white;">
                                <i class="bi bi-shop me-1"></i>Visiter
                            </button>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-heart"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-share"></i>
                            </button>
                        </div>

                        <!-- Date d'ajout -->
                        <div class="mt-3">
                            <small class="text-muted" style="font-size: 0.75rem;">
                                <i class="bi bi-calendar3 me-1"></i>Ajoutée le {{ date('d/m/Y', strtotime('-' . rand(1, 30) . ' days')) }}
                            </small>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <!-- Section statistiques globales -->
            <div class="mt-4 p-3 rounded-3" style="background: linear-gradient(135deg, rgba(30, 64, 175, 0.05), rgba(59, 130, 246, 0.05)); border: 1px solid rgba(30, 64, 175, 0.1);">
                <div class="row text-center">
                    <div class="col-md-3 col-6">
                        <div class="fw-bold fs-5" style="color: var(--primary-blue);">{{ rand(50, 150) }}+</div>
                        <small class="text-muted">Nouvelles boutiques ce mois</small>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="fw-bold fs-5" style="color: var(--success-green);">{{ rand(1000, 5000) }}+</div>
                        <small class="text-muted">Nouveaux produits</small>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="fw-bold fs-5" style="color: #fbbf24;">{{ rand(15, 25) }}%</div>
                        <small class="text-muted">Cashback moyen</small>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="fw-bold fs-5" style="color: #f97316;">{{ rand(80, 99) }}%</div>
                        <small class="text-muted">Satisfaction client</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3 Colonnes : Kdo Surprise, Destockage, Prix Cassés (Version compacte avec animations) -->
    <div class="mx-3 mb-4">
        <style>
            @keyframes shimmer {
                0% { background-position: -200% 0; }
                100% { background-position: 200% 0; }
            }
            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }
            .promo-card {
                transition: all 0.3s ease;
                background-size: 200% 100%;
                animation: shimmer 3s infinite;
            }
            .promo-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            }
            .promo-icon {
                animation: pulse 2s infinite;
            }
            .floating-element {
                animation: float 3s ease-in-out infinite;
            }
        </style>

        <div class="row g-3">
            <!-- Colonne 1: Kdo Surprise -->
            <div class="col-lg-4">
                <div class="promo-card rounded-3 overflow-hidden" style="background: linear-gradient(135deg, #ec4899, #db2777, #ec4899); position: relative; height: 200px;">
                    <div class="p-3 h-100 d-flex align-items-center text-white">
                        <div class="me-3 promo-icon" style="background: rgba(255,255,255,0.2); padding: 8px; border-radius: 50%; backdrop-filter: blur(10px);">
                            <i class="bi bi-gift fs-4 text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold mb-1">Kdo Surprise</h5>
                            <p class="mb-2 opacity-75" style="font-size: 0.85rem;">Cadeau mystère inclus</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="fw-bold">{{ rand(50, 200) }}+ cadeaux</small>
                                </div>
                                <button class="btn btn-light btn-sm fw-bold" style="color: #db2777; font-size: 0.75rem;">
                                    <i class="bi bi-arrow-right me-1"></i>Découvrir
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Effet de brillance animé -->
                    <div class="floating-element" style="position: absolute; top: 10px; right: 10px; width: 30px; height: 30px; background: rgba(255,255,255,0.3); border-radius: 50%; opacity: 0.7;"></div>
                    <div class="floating-element" style="position: absolute; bottom: 15px; left: 10px; width: 20px; height: 20px; background: rgba(255,255,255,0.2); border-radius: 50%; opacity: 0.5; animation-delay: 1s;"></div>
                </div>
            </div>

            <!-- Colonne 2: Destockage -->
            <div class="col-lg-4">
                <div class="promo-card rounded-3 overflow-hidden" style="background: linear-gradient(135deg, #f97316, #ea580c, #f97316); position: relative; height: 200px;">
                    <div class="p-3 h-100 d-flex align-items-center text-white">
                        <div class="me-3 promo-icon" style="background: rgba(255,255,255,0.2); padding: 8px; border-radius: 50%; backdrop-filter: blur(10px); animation-delay: 0.5s;">
                            <i class="bi bi-box-seam fs-4 text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold mb-1">Destockage</h5>
                            <p class="mb-2 opacity-75" style="font-size: 0.85rem;">Liquidation totale</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="fw-bold">-{{ rand(50, 80) }}% max</small>
                                </div>
                                <button class="btn btn-light btn-sm fw-bold" style="color: #ea580c; font-size: 0.75rem;">
                                    <i class="bi bi-arrow-right me-1"></i>Voir tout
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Effet de brillance animé -->
                    <div class="floating-element" style="position: absolute; top: 15px; right: 15px; width: 25px; height: 25px; background: rgba(255,255,255,0.3); border-radius: 50%; opacity: 0.6; animation-delay: 2s;"></div>
                    <div class="floating-element" style="position: absolute; bottom: 10px; left: 15px; width: 35px; height: 35px; background: rgba(255,255,255,0.2); border-radius: 50%; opacity: 0.4;"></div>
                </div>
            </div>

            <!-- Colonne 3: Prix Cassés -->
            <div class="col-lg-4">
                <div class="promo-card rounded-3 overflow-hidden" style="background: linear-gradient(135deg, #ef4444, #dc2626, #ef4444); position: relative; height: 200px;">
                    <div class="p-3 h-100 d-flex align-items-center text-white">
                        <div class="me-3 promo-icon" style="background: rgba(255,255,255,0.2); padding: 8px; border-radius: 50%; backdrop-filter: blur(10px); animation-delay: 1s;">
                            <i class="bi bi-hammer fs-4 text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold mb-1">Prix Cassés</h5>
                            <p class="mb-2 opacity-75" style="font-size: 0.85rem;">Offres imbattables</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="fw-bold">-{{ rand(60, 90) }}% origine</small>
                                </div>
                                <button class="btn btn-light btn-sm fw-bold" style="color: #dc2626; font-size: 0.75rem;">
                                    <i class="bi bi-lightning-charge me-1"></i>Voir prix
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Effet de brillance animé -->
                    <div class="floating-element" style="position: absolute; top: 12px; right: 12px; width: 28px; height: 28px; background: rgba(255,255,255,0.4); border-radius: 50%; opacity: 0.8; animation-delay: 1.5s;"></div>
                    <div class="floating-element" style="position: absolute; bottom: 12px; left: 12px; width: 22px; height: 22px; background: rgba(255,255,255,0.3); border-radius: 50%; opacity: 0.6; animation-delay: 0.5s;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Produits Populaires -->
    <div class="mx-3 mb-4">
        <div class="p-4 rounded-3" style="background: rgba(139,92,246,0.10); position: relative; overflow: hidden;">
            <!-- Violet très clair, opacité 0.10 -->
            <!-- Effet de brillance animé -->
            <style>
                @keyframes violet-shimmer {
                    0% { background-position: -200% 0; }
                    100% { background-position: 200% 0; }
                }
                .violet-shimmer {
                    background: linear-gradient(135deg, #8b5cf6, #7c3aed, #6d28d9, #8b5cf6, #7c3aed);
                    background-size: 400% 400%;
                    animation: violet-shimmer 3s ease-in-out infinite;
                }
                .violet-glow {
                    box-shadow: 0 0 30px rgba(139, 92, 246, 0.3), 0 0 60px rgba(124, 58, 237, 0.2);
                }
            </style>

            <!-- Cercles flottants décoratifs -->
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%; opacity: 0.6;"></div>
            <div style="position: absolute; bottom: -30px; left: -30px; width: 80px; height: 80px; background: rgba(255,255,255,0.08); border-radius: 50%; opacity: 0.4;"></div>
            <div style="position: absolute; top: 50%; right: 10%; width: 60px; height: 60px; background: rgba(255,255,255,0.05); border-radius: 50%; opacity: 0.3;"></div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1 text-white">Produits Populaires</h3>
                    <p class="text-white opacity-75 mb-0">Les meilleures ventes avec cashback</p>
                </div>
                <a href="{{ route('boutiques.index') }}" class="btn btn-light fw-bold" style="color: #7c3aed;">
                    <i class="bi bi-arrow-right me-1"></i>Voir tout
                </a>
            </div>
            <div class="row g-4">
            @forelse($topProduits as $produit)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-card h-100">
                        <div class="position-relative">
                            <img src="{{ $produit->image ?? 'https://via.placeholder.com/300x300?text=Produit&bg=f0f9ff&color=1e40af' }}" class="card-img-top" alt="{{ $produit->nom }}" style="height: 200px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge" style="background: var(--secondary-blue);">{{ $produit->achats_count ?? 0 }} ventes</span>
                            </div>
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-success">-15%</span>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <h6 class="card-title mb-2 fw-bold">{{ $produit->nom }}</h6>
                            <div class="small text-muted mb-2">
                                <i class="bi bi-shop me-1"></i>{{ $produit->boutique->nom ?? 'Boutique' }}
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <span class="fw-bold" style="color: var(--primary-blue);">{{ number_format($produit->prix ?? 25000, 0, ',', ' ') }} FCFA</span>
                                    <small class="text-muted text-decoration-line-through ms-1">{{ number_format(($produit->prix ?? 25000) * 1.15, 0, ',', ' ') }}</small>
                                </div>
                                <div class="text-end">
                                    <small class="text-success fw-bold">+{{ rand(5, 15) }}% cashback</small>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('produits.show', $produit->id) }}" class="btn btn-sm flex-fill" style="background: var(--secondary-blue); color: white;">Voir</a>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-box-seam display-1 text-muted mb-3"></i>
                        <h5 class="text-muted">Aucun produit disponible</h5>
                        <p class="text-muted">Les produits populaires apparaîtront ici bientôt.</p>
                        <a href="{{ route('boutiques.index') }}" class="btn btn-primary">Explorer les boutiques</a>
                    </div>
                </div>
            @endforelse
            </div>
        </div>
    </div>
    <!-- Section Commandes Récentes SUPPRIMÉE -->
            <div>
                <h3 class="fw-bold mb-1" style="color: var(--primary-blue);">Mes Commandes Récentes</h3>
                <p class="text-muted mb-0">Suivi de vos achats et cashbacks</p>
            </div>
            <a href="#" class="btn btn-outline-primary btn-sm">Voir tout</a>
        </div>
        <div class="row g-3">
            @foreach(($commandes ?? [
                ['date'=>'2025-07-20','boutique'=>'Boutique A','montant'=>8500,'statut'=>'Livrée','cashback'=>850],
                ['date'=>'2025-07-15','boutique'=>'Boutique B','montant'=>4200,'statut'=>'En cours','cashback'=>420],
                ['date'=>'2025-07-10','boutique'=>'Boutique C','montant'=>12000,'statut'=>'Annulée','cashback'=>0],
                ['date'=>'2025-07-09','boutique'=>'Boutique D','montant'=>3300,'statut'=>'Livrée','cashback'=>330],
            ]) as $cmd)
            <div class="col-md-6 col-lg-4">
                <div class="cashback-card p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="fw-bold mb-1">{{ $cmd['boutique'] }}</h6>
                            <small class="text-muted">{{ $cmd['date'] }}</small>
                        </div>
                        <div>
                            @if($cmd['statut']==='Livrée')
                                <span class="badge bg-success">Livrée</span>
                            @elseif($cmd['statut']==='En cours')
                                <span class="badge" style="background: var(--light-blue); color: white;">En cours</span>
                            @elseif($cmd['statut']==='Annulée')
                                <span class="badge bg-danger">Annulée</span>
                            @else
                                <span class="badge bg-secondary">{{ $cmd['statut'] }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold" style="color: var(--primary-blue);">{{ number_format($cmd['montant'], 0, ',', ' ') }} FCFA</div>
                            @if($cmd['cashback'] > 0)
                                <small class="text-success">+{{ number_format($cmd['cashback'], 0, ',', ' ') }} FCFA cashback</small>
                            @endif
                        </div>
                        <i class="bi bi-arrow-right-circle" style="color: var(--accent-blue);"></i>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Section Promotions Spéciales -->
    <div class="container mb-5">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="p-4 rounded-4" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: white;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="fw-bold mb-2">DAILY BEST</h4>
                            <p class="mb-3 opacity-75">Offres spéciales du jour</p>
                            <button class="btn btn-light fw-bold" style="color: #f59e0b;">Découvrir</button>
                        </div>
                        <div class="display-4">🎆</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4 rounded-4" style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); color: white;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="fw-bold mb-2">MEGA SALE</h4>
                            <p class="mb-3 opacity-75">Weekend seulement</p>
                            <button class="btn btn-light fw-bold" style="color: #db2777;">Voir les offres</button>
                        </div>
                        <div class="display-4">🎉</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Notifications -->
    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1" style="color: var(--primary-blue);">Notifications</h3>
                <p class="text-muted mb-0">Restez informé des dernières nouveautés</p>
            </div>
            <button class="btn btn-outline-primary btn-sm">Marquer comme lues</button>
        </div>
        <div class="row g-3">
            @foreach(($notifications ?? [
                ['type'=>'vente flash','message'=>'Vente flash sur Boutique A jusqu\'\u00e0 ce soir !','date'=>'2025-07-23','time'=>'14:30'],
                ['type'=>'cashback','message'=>'Votre cashback de 2 000 FCFA a été validé.','date'=>'2025-07-21','time'=>'09:15'],
                ['type'=>'bon plan','message'=>'Nouveau bon plan disponible sur Boutique C.','date'=>'2025-07-20','time'=>'16:45'],
            ]) as $notif)
            <div class="col-md-6">
                <div class="notification-card p-3">
                    <div class="d-flex align-items-start">
                        <div class="me-3">
                            @if($notif['type']==='vente flash')
                                <div class="rounded-circle p-2" style="background: var(--accent-blue);">
                                    <i class="bi bi-lightning-charge-fill text-white"></i>
                                </div>
                            @elseif($notif['type']==='cashback')
                                <div class="rounded-circle p-2" style="background: #10b981;">
                                    <i class="bi bi-cash-coin text-white"></i>
                                </div>
                            @elseif($notif['type']==='bon plan')
                                <div class="rounded-circle p-2" style="background: var(--secondary-blue);">
                                    <i class="bi bi-gift text-white"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1 fw-medium">{{ $notif['message'] }}</p>
                            <small class="text-muted">{{ $notif['date'] }} à {{ $notif['time'] }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Section Just For You -->
    <div class="container mb-5">
        <div class="text-center mb-4">
            <h3 class="fw-bold mb-1" style="color: var(--primary-blue);">Juste pour vous</h3>
            <p class="text-muted">Recommandations personnalisées basées sur vos préférences</p>
        </div>
        <div class="row g-4">
            @for($i = 1; $i <= 4; $i++)
            <div class="col-lg-3 col-md-6">
                <div class="product-card h-100">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/300x200?text=Produit+{{ $i }}&bg=f0f9ff&color=1e40af" class="card-img-top" style="height: 150px; object-fit: cover;">
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-danger">-{{ rand(10, 30) }}%</span>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-2">Produit Recommandé {{ $i }}</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold" style="color: var(--primary-blue);">{{ number_format(rand(15000, 50000), 0, ',', ' ') }} FCFA</span>
                            <small class="text-success">+{{ rand(5, 20) }}% cashback</small>
                        </div>
                        <button class="btn btn-sm w-100" style="background: var(--secondary-blue); color: white;">Ajouter au panier</button>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>
@endsection
