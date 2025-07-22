<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CabaCaba</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        body { background: #f3f4f6; }
        .header-cbm {
            background: #2563eb;
            color: #fff;
        }
        .footer-cbm {
            background: #2563eb;
            color: #fff;
        }
        .btn-cbm {
            background: #22c55e;
            color: #fff;
            border: none;
        }
        .btn-cbm:hover {
            background: #2563eb;
            color: #fff;
        }
        .badge-cbm {
            background: #fbbf24;
            color: #22223b;
        }
        .card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(34,34,59,0.07);
        }
        .menu-link {
            font-family: 'Tahoma', sans-serif;
            text-decoration: none !important;
            font-size: 0.98rem;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
            border-radius: 4px;
            padding-left: 0.5rem;
        }
        .menu-link:hover {
            background: #e3f0ff;
            color: #0d6efd !important;
        }
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1 0 auto;
        }
        footer {
            flex-shrink: 0;
        }
    </style>
</head>
<body>
    @include('partials.userbar')
    <!-- Header Côte d'Ivoire simplifié -->
    <header class="header-cbm py-3 mb-4 shadow-sm">
        <div class="container d-flex flex-wrap align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <i class="bi bi-cash-coin fs-2 me-2"></i>
                <span class="fs-4 fw-bold">CabaCaba</span>
            </a>
            <nav>
                <ul class="nav nav-pills">
                    <li class="nav-item"><a href="{{ route('home') }}" class="nav-link text-white">Accueil</a></li>
                    <li class="nav-item"><a href="{{ route('boutiques.index') }}" class="nav-link text-white">Boutiques</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-white">Créer votre liste de mariage</a></li>
                    @auth
                    <li class="nav-item dropdown ms-2">
                        <a class="btn btn-cbm btn-sm px-3 py-1 dropdown-toggle d-flex align-items-center" href="#" id="menuCompte" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i> Mon compte
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="menuCompte">
                            <li><a class="dropdown-item" href="#">Inviter des amis</a></li>
                            <li><a class="dropdown-item" href="#">Voir mes gains</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('account.dashboard') }}">Tableau de bord</a></li>
                        </ul>
                    </li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>
    @yield('content')
    <!-- Footer enrichi -->
    <footer class="footer-cbm py-4 mt-auto">
        <div class="container">
            <div class="row align-items-center mb-3">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="fw-bold mb-2">Contact rapide</div>
                    <form class="d-flex flex-column flex-sm-row gap-2">
                        <input type="email" class="form-control form-control-sm" placeholder="Votre email" required>
                        <button class="btn btn-cbm btn-sm" type="submit">Envoyer</button>
                    </form>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="fw-bold mb-2">Newsletter</div>
                    <form class="d-flex flex-column flex-sm-row gap-2">
                        <input type="email" class="form-control form-control-sm" placeholder="Saisissez votre email" required>
                        <button class="btn btn-cbm btn-sm" type="submit">S'abonner</button>
                    </form>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="fw-bold mb-2">Suivez-nous</div>
                    <a href="#" class="text-white me-2"><i class="bi bi-facebook fs-5"></i></a>
                    <a href="#" class="text-white me-2"><i class="bi bi-instagram fs-5"></i></a>
                    <a href="#" class="text-white me-2"><i class="bi bi-twitter fs-5"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-youtube fs-5"></i></a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center small">
                    <a href="#" class="text-white text-decoration-underline me-2">Mentions légales</a>
                    <a href="#" class="text-white text-decoration-underline me-2">CGU</a>
                    <a href="#" class="text-white text-decoration-underline">Contact</a>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
