<header class="border-bottom bg-white shadow-sm">
    <!-- Main Header -->
    <div class="container-fluid py-3 d-flex align-items-center justify-content-between">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="navbar-brand fw-bold fs-3" style="color:#FF6A00;"><i class="bi bi-wallet2 me-2"></i>CBM</a>



        <!-- Icônes rapides -->
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('notifications.index') }}" class="position-relative text-decoration-none" style="color:#333;">
                <i class="bi bi-bell fs-5"></i>
            </a>
            <a href="{{ route('favorites.index') }}" class="position-relative text-decoration-none" style="color:#333;">
                <i class="bi bi-heart fs-5"></i>
            </a>
            <a href="{{ route('cart.index') }}" class="position-relative text-decoration-none" style="color:#333;">
                <i class="bi bi-cart fs-5"></i>
                @php
    $cartCount = Cart::count();
@endphp
                @if($cartCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                        {{ $cartCount }}
                        <span class="visually-hidden">articles dans le panier</span>
                    </span>
                @endif
            </a>
            @auth
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle text-decoration-none" style="color:#333;" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person fs-5"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</a></li>
                        <li><a class="dropdown-item" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart me-2"></i>Mon panier
                            @if($cartCount > 0)
                                <span class="badge bg-danger float-end">{{ $cartCount }}</span>
                            @endif
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}" 
                              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                        </a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </div>
            @endauth
        </div>
    </div>

    <!-- Navigation principale -->
    <nav class="navbar navbar-expand-lg" style="background:#fff;">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            Toutes les catégories
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Bâtiment</a></li>
                            <li><a class="dropdown-item" href="#">Agroalimentaire</a></li>
                            <li><a class="dropdown-item" href="#">Équipements</a></li>
                            <!-- Ajoute d'autres catégories -->
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Produits prêts à l’expédition</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Équipements de protection</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Services CBM</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Communauté</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Application mobile</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
