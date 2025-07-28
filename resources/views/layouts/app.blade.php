<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashback Market</title>
    
    <!-- Meta tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js pour les menus déroulants -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Styles personnalisés -->
    <style>
        body { 
            background: #f3f4f6; 
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .footer-cbm {
            background: #1a1a2e;
            color: #fff;
        }
        
        .btn-cbm {
            background: #22c55e;
            color: #fff;
            border: none;
            transition: all 0.2s ease-in-out;
        }
        
        .btn-cbm:hover {
            background: #1e9c4e;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .badge-cbm {
            background: #fbbf24;
            color: #22223b;
            font-weight: 600;
        }
        
        .card {
            background: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .menu-link {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-decoration: none !important;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
        }
        
        .menu-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
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
<body class="min-h-screen flex flex-col">
    <!-- Nouveau Header -->
    <x-layout.header />

    <!-- Contenu principal -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-cbm py-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <!-- À propos -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">À propos</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Qui sommes-nous ?</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Comment ça marche ?</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Nos services</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Blog</a></li>
                    </ul>
                </div>

                <!-- Aide -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Aide & Contact</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Centre d'aide</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Nous contacter</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Support</a></li>
                    </ul>
                </div>

                <!-- Légales -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Informations légales</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Conditions générales</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Politique de confidentialité</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Mentions légales</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Cookies</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
                    <p class="text-gray-300 mb-4">Inscrivez-vous pour recevoir nos offres exclusives</p>
                    <form class="space-y-3">
                        <div>
                            <input type="email" placeholder="Votre adresse email" class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition-colors w-full">
                            S'abonner
                        </button>
                    </form>
                    <div class="mt-4">
                        <p class="text-gray-300 mb-2">Suivez-nous</p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                <i class="fab fa-facebook-f text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                <i class="fab fa-youtube text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-700 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Cashback Market. Tous droits réservés.</p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <img src="{{ asset('images/payment-methods/visa.png') }}" alt="Visa" class="h-8">
                        <img src="{{ asset('images/payment-methods/mastercard.png') }}" alt="Mastercard" class="h-8">
                        <img src="{{ asset('images/payment-methods/paypal.png') }}" alt="PayPal" class="h-8">
                        <img src="{{ asset('images/payment-methods/cb.png') }}" alt="CB" class="h-8">
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Scripts personnalisés ici
        document.addEventListener('DOMContentLoaded', function() {
            // Initialisation des composants
            const dropdowns = document.querySelectorAll('.group');
            
            dropdowns.forEach(dropdown => {
                dropdown.addEventListener('mouseenter', function() {
                    this.querySelector('.group-hover\:block').classList.remove('hidden');
                });
                
                dropdown.addEventListener('mouseleave', function() {
                    this.querySelector('.group-hover\:block').classList.add('hidden');
                });
            });

            // Gestion du menu mobile
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
