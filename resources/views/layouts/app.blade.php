<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashback Market</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Styles personnalisés -->
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
            padding: 0.5rem 1rem;
        }
        .menu-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #fff !important;
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
            padding-bottom: 2rem;
        }
        footer {
            flex-shrink: 0;
            margin-top: auto;
        }
        .userbar-link {
            transition: all 0.2s ease;
            padding: 4px 8px;
            border-radius: 4px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }
        .userbar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff !important;
        }
    </style>
</head>
<body>
    @include('layouts.header')
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
