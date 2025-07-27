<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cashback Market - Économisez sur vos achats en ligne</title>
    <meta name="description" content="Économisez de l'argent sur vos achats en ligne avec Cashback Market. Obtenez des remises en cashback dans des centaines de boutiques partenaires.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary: #1e40af;
            --primary-light: #3b82f6;
            --secondary: #10b981;
            --dark: #1f2937;
            --light: #f3f4f6;
            --gray: #6b7280;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: var(--dark);
            line-height: 1.6;
        }
        
        /* Navigation */
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary);
            display: flex;
            align-items: center;
        }
        
        .navbar-brand img {
            margin-right: 0.5rem;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--dark);
            padding: 0.5rem 1rem;
            transition: color 0.2s ease;
        }
        
        .nav-link:hover {
            color: var(--primary);
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
            transform: translateY(-2px);
        }
        
        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        
        .hero-section p {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            max-width: 600px;
        }
        
        /* Account Types */
        .account-card {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            text-align: center;
        }
        
        .account-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .account-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
        }
        
        .account-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark);
        }
        
        .account-card p {
            color: var(--gray);
            margin-bottom: 1.5rem;
        }
        
        /* Features Section */
        .feature-icon {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            background-color: rgba(59, 130, 246, 0.1);
            color: var(--primary);
            font-size: 1.75rem;
        }
        
        .feature-card {
            padding: 2rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        /* Testimonials */
        .testimonial-card {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .testimonial-avatar {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
        }
        
        .testimonial-rating {
            color: #f59e0b;
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }
        
        .testimonial-text {
            font-style: italic;
            color: var(--gray);
            margin-bottom: 1.5rem;
        }
        
        .testimonial-author {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }
        
        .testimonial-role {
            color: var(--gray);
            font-size: 0.875rem;
        }
        
        /* Footer */
        .footer {
            background-color: #111827;
            color: #9ca3af;
            padding: 4rem 0 2rem;
        }
        
        .footer-title {
            color: white;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.75rem;
        }
        
        .footer-links a {
            color: #9ca3af;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .social-link {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .social-link:hover {
            background-color: var(--primary);
            transform: translateY(-2px);
        }
        
        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            margin-top: 4rem;
            text-align: center;
            font-size: 0.875rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2.25rem;
            }
            
            .hero-section p {
                font-size: 1.125rem;
            }
            
            .account-card {
                margin-bottom: 1.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .hero-section {
                padding: 3rem 0;
                text-align: center;
            }
            
            .hero-section h1 {
                font-size: 2rem;
            }
            
            .hero-section p {
                font-size: 1rem;
            }
            
            .btn {
                display: block;
                width: 100%;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Cashback Market" height="40" class="d-inline-block align-text-top me-2">
                Cashback Market
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">S'inscrire</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Tableau de bord</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Mon compte
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profil</a></li>
                                <li><a class="dropdown-item" href="{{ route('account.orders.index') }}">Mes commandes</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Déconnexion</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1>Économisez sur tous vos achats en ligne</h1>
                    <p class="lead mb-4">Achetez dans vos boutiques préférées et obtenez un pourcentage de votre achat remboursé directement sur votre compte.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#account-types" class="btn btn-light btn-lg px-4">Commencer maintenant</a>
                        <a href="#how-it-works" class="btn btn-outline-light btn-lg px-4">Comment ça marche ?</a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="{{ asset('images/hero-illustration.svg') }}" alt="Économisez avec Cashback Market" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Account Types -->
    <section id="account-types" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Choisissez votre type de compte</h2>
                <p class="text-muted">Sélectionnez le type de compte qui correspond à vos besoins</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="account-card">
                        <div class="account-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        <h3>Acheteur</h3>
                        <p>Je veux faire des économies sur mes achats en ligne en recevant du cashback.</p>
                        <a href="{{ route('register', ['type' => 'buyer']) }}" class="btn btn-primary w-100">S'inscrire comme acheteur</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="account-card">
                        <div class="account-icon">
                            <i class="bi bi-shop"></i>
                        </div>
                        <h3>Vendeur</h3>
                        <p>Je possède une boutique en ligne et je veux attirer plus de clients.</p>
                        <a href="{{ route('register', ['type' => 'seller']) }}" class="btn btn-primary w-100">S'inscrire comme vendeur</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="account-card">
                        <div class="account-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h3>Partenaire</h3>
                        <p>Je veux gagner de l'argent en parrainant des acheteurs et des vendeurs.</p>
                        <a href="{{ route('register', ['type' => 'partner']) }}" class="btn btn-primary w-100">Devenir partenaire</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Comment ça marche ?</h2>
                <p class="text-muted">Découvrez comment économiser facilement sur vos achats</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <h4>1. Créez un compte</h4>
                        <p class="text-muted">Inscrivez-vous gratuitement en tant qu'acheteur pour commencer à économiser.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-cart"></i>
                        </div>
                        <h4>2. Faites vos achats</h4>
                        <p class="text-muted">Accédez à nos boutiques partenaires depuis votre tableau de bord.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-currency-euro"></i>
                        </div>
                        <h4>3. Recevez votre cashback</h4>
                        <p class="text-muted">Obtenez un pourcentage de votre achat remboursé sur votre compte.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Ils nous font confiance</h2>
                <p class="text-muted">Découvrez ce que nos utilisateurs pensent de Cashback Market</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">M</div>
                        <div class="testimonial-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="testimonial-text">"J'ai économisé plus de 200€ en seulement 3 mois grâce à Cashback Market. C'est devenu un réflexe avant chaque achat en ligne !"</p>
                        <div class="testimonial-author">Marie D.</div>
                        <div class="testimonial-role">Membre depuis 2022</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">P</div>
                        <div class="testimonial-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <p class="testimonial-text">"En tant que vendeur, Cashback Market m'a permis d'augmenter mon chiffre d'affaires de 30% en quelques mois seulement."</p>
                        <div class="testimonial-author">Pierre M.</div>
                        <div class="testimonial-role">Vendeur partenaire</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">S</div>
                        <div class="testimonial-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="testimonial-text">"Le système de parrainage est génial. J'ai déjà gagné plus de 500€ en parrainant mes amis et ma famille."</p>
                        <div class="testimonial-author">Sophie L.</div>
                        <div class="testimonial-role">Partenaire</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Prêt à commencer à économiser ?</h2>
            <p class="lead mb-4">Rejoignez des milliers de membres qui économisent déjà sur leurs achats en ligne.</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">S'inscrire gratuitement</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h3 class="footer-title">Cashback Market</h3>
                    <p>La plateforme de cashback préférée des français. Économisez sur tous vos achats en ligne.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h4 class="footer-title">À propos</h4>
                    <ul class="footer-links">
                        <li><a href="#">Qui sommes-nous ?</a></li>
                        <li><a href="#">Comment ça marche</a></li>
                        <li><a href="#">Devenir partenaire</a></li>
                        <li><a href="#">Carrières</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h4 class="footer-title">Aide</h4>
                    <ul class="footer-links">
                        <li><a href="#">Centre d'aide</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Nous contacter</a></li>
                        <li><a href="#">Statut du service</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h4 class="footer-title">Légal</h4>
                    <ul class="footer-links">
                        <li><a href="#">Conditions d'utilisation</a></li>
                        <li><a href="#">Politique de confidentialité</a></li>
                        <li><a href="#">Politique de cookies</a></li>
                        <li><a href="#">Mentions légales</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h4 class="footer-title">Contact</h4>
                    <ul class="footer-links">
                        <li>contact@cashbackmarket.com</li>
                        <li>+33 1 23 45 67 89</li>
                        <li>123 Rue du Commerce<br>75001 Paris, France</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; {{ date('Y') }} Cashback Market. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
