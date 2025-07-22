<header class="bg-white shadow-sm py-3 mb-4">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center flex-grow-1">
            <button class="btn btn-outline-primary me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
                <i class="bi bi-list fs-2"></i>
            </button>
            <i class="bi bi-piggy-bank-fill" style="font-size:3rem;color:#0d6efd;margin-right:1rem;"></i>
            <span class="fw-bold" style="font-size:2.5rem;color:#b80000;letter-spacing:2px;">CabaCaba!</span>
        </div>
        <div class="d-flex align-items-center">
            <form class="d-none d-md-flex me-3" role="search">
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="Rechercher..." aria-label="Rechercher">
                    <select class="form-select" aria-label="Filtrer par cashback">
                        <option selected>Cashback</option>
                        <option value="all">Tous</option>
                        <option value="high">Élevé</option>
                        <option value="medium">Moyen</option>
                        <option value="low">Faible</option>
                    </select>
                    <select class="form-select" aria-label="Filtrer par catégorie">
                        <option selected>Catégories</option>
                        <option value="mode">Mode</option>
                        <option value="high-tech">High-Tech</option>
                        <option value="maison">Maison</option>
                        <option value="voyages">Voyages</option>
                        <option value="autres">Autres</option>
                    </select>
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
            <i class="bi bi-person-circle fs-2 text-secondary me-2"></i>
            <span class="fw-semibold">{{ Auth::user()->name ?? 'Profil' }}</span>
        </div>
    </div>
</header>
<!-- Offcanvas menu mobile -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel" style="background:#002147;color:#fff;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="mobileMenuLabel">Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="row">
            <div class="col-12 col-md-6">
                <ul class="list-unstyled mb-0">
                    <li><a href="{{ route('home') }}" class="menu-link text-white d-block py-2"><i class="bi bi-house me-2"></i>Accueil</a></li>
                    <li><a href="{{ route('boutiques.index') }}" class="menu-link text-white d-block py-2"><i class="bi bi-shop me-2"></i>Boutiques</a></li>
                    <li><a href="#" class="menu-link text-white d-block py-2"><i class="bi bi-tags me-2"></i>Catégories</a></li>
                    <li><a href="#" class="menu-link text-white d-block py-2"><i class="bi bi-lightning me-2"></i>Chap Chap</a></li>
                    <li><a href="#" class="menu-link text-white d-block py-2"><i class="bi bi-info-circle me-2"></i>À propos</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-6">
                <ul class="list-unstyled mb-0 ps-md-3">
                    <li><a href="{{ route('register') }}" class="menu-link text-white d-block py-2"><i class="bi bi-person-plus me-2"></i>Inscription</a></li>
                    <li><a href="#" class="menu-link text-white d-block py-2"><i class="bi bi-question-circle me-2"></i>Fonctionnement</a></li>
                    <li><a href="#" class="menu-link text-white d-block py-2"><i class="bi bi-credit-card me-2"></i>Ma carte virtuelle</a></li>
                    <li><a href="#" class="menu-link text-white d-block py-2"><i class="bi bi-people me-2"></i>Mon cercle d'amis</a></li>
                    <li><a href="#" class="menu-link text-white d-block py-2"><i class="bi bi-robot me-2"></i>Conseiller AI</a></li>
                </ul>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
            <div style="width:90%;height:90px;background:#fff;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:center;">
                <span class="text-muted">Espace publicitaire</span>
            </div>
        </div>
    </div>
</div>
