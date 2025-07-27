<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tableau de bord - Admin') - {{ config('app.name') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans">
    <!-- Sidebar -->
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-indigo-700">
                <div class="flex flex-col flex-grow pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-white text-2xl font-bold">
                            {{ config('app.name') }} Admin
                        </a>
                    </div>
                    <nav class="mt-5 flex-1 px-2 space-y-1">
                        <!-- Tableau de bord -->
                        <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-indigo-100 hover:bg-indigo-600 hover:bg-opacity-75 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-800' : '' }}">
                            <i class="fas fa-tachometer-alt mr-3 flex-shrink-0 h-6 w-6"></i>
                            Tableau de bord
                        </a>
                        
                        <!-- Boutiques -->
                        <a href="{{ route('admin.boutiques.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-indigo-100 hover:bg-indigo-600 hover:bg-opacity-75 {{ request()->routeIs('admin.boutiques.*') ? 'bg-indigo-800' : '' }}">
                            <i class="fas fa-store mr-3 flex-shrink-0 h-6 w-6"></i>
                            Boutiques
                        </a>
                        
                        <!-- Produits -->
                        <a href="{{ route('admin.produits.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-indigo-100 hover:bg-indigo-600 hover:bg-opacity-75 {{ request()->routeIs('admin.produits.*') ? 'bg-indigo-800' : '' }}">
                            <i class="fas fa-boxes mr-3 flex-shrink-0 h-6 w-6"></i>
                            Produits
                        </a>
                        
                        <!-- Commandes -->
                        <a href="#" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-indigo-100 hover:bg-indigo-600 hover:bg-opacity-75">
                            <i class="fas fa-shopping-cart mr-3 flex-shrink-0 h-6 w-6"></i>
                            Commandes
                        </a>
                        
                        <!-- Utilisateurs -->
                        <a href="#" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-indigo-100 hover:bg-indigo-600 hover:bg-opacity-75">
                            <i class="fas fa-users mr-3 flex-shrink-0 h-6 w-6"></i>
                            Utilisateurs
                        </a>
                        
                        <!-- Catégories -->
                        <a href="#" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-indigo-100 hover:bg-indigo-600 hover:bg-opacity-75">
                            <i class="fas fa-tags mr-3 flex-shrink-0 h-6 w-6"></i>
                            Catégories
                        </a>
                        
                        <!-- Paramètres -->
                        <a href="#" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-indigo-100 hover:bg-indigo-600 hover:bg-opacity-75">
                            <i class="fas fa-cog mr-3 flex-shrink-0 h-6 w-6"></i>
                            Paramètres
                        </a>
                    </nav>
                </div>
                <div class="flex-shrink-0 flex border-t border-indigo-800 p-4">
                    <div class="flex items-center">
                        <div>
                            <img class="inline-block h-9 w-9 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="">
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                            <a href="{{ route('profile.show') }}" class="text-xs font-medium text-indigo-200 group-hover:text-white">
                                Voir le profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contenu principal -->
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <!-- Barre de navigation supérieure -->
            <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
                <button @click="sidebarOpen = true" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden">
                    <span class="sr-only">Ouvrir le menu</span>
                    <i class="fas fa-bars h-6 w-6"></i>
                </button>
                <div class="flex-1 px-4 flex justify-between">
                    <div class="flex-1 flex">
                        <form class="w-full flex md:ml-0" action="#" method="GET">
                            <label for="search-field" class="sr-only">Rechercher</label>
                            <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                                <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                    <i class="fas fa-search h-5 w-5"></i>
                                </div>
                                <input id="search-field" name="search-field" class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-0 focus:border-transparent sm:text-sm" placeholder="Rechercher..." type="search">
                            </div>
                        </form>
                    </div>
                    <div class="ml-4 flex items-center md:ml-6">
                        <!-- Notifications -->
                        <button type="button" class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="sr-only">Voir les notifications</span>
                            <i class="far fa-bell h-6 w-6"></i>
                        </button>
                        
                        <!-- Menu déroulant du profil -->
                        <div class="ml-3 relative" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open" type="button" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Ouvrir le menu utilisateur</span>
                                    <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="">
                                </button>
                            </div>
                            
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu" style="display: none;">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    <i class="fas fa-user-circle mr-2"></i> Mon profil
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    <i class="fas fa-cog mr-2"></i> Paramètres
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contenu de la page -->
            <main class="flex-1 relative overflow-y-auto focus:outline-none">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <h1 class="text-2xl font-semibold text-gray-900">@yield('header')</h1>
                    </div>
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <!-- Messages flash -->
                        @if (session('success'))
                            <div class="rounded-md bg-green-50 p-4 mb-6">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="h-5 w-5 text-green-400 fas fa-check-circle"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-800">
                                            {{ session('success') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        @if (session('error'))
                            <div class="rounded-md bg-red-50 p-4 mb-6">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="h-5 w-5 text-red-400 fas fa-exclamation-circle"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-red-800">
                                            {{ session('error') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Contenu de la page -->
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Scripts -->
    @stack('scripts')
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @if(isset($monthlySales) && isset($monthlyUsers))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Graphique des ventes mensuelles
            const salesCtx = document.getElementById('monthlySalesChart');
            if (salesCtx) {
                new Chart(salesCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($monthlySales['labels']) !!},
                        datasets: [{
                            label: 'Ventes mensuelles (FCFA)',
                            data: {!! json_encode($monthlySales['data']) !!},
                            borderColor: 'rgb(79, 70, 229)',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            tension: 0.3,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return new Intl.NumberFormat('fr-FR', { 
                                            style: 'currency', 
                                            currency: 'XOF',
                                            maximumFractionDigits: 0 
                                        }).format(context.raw);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return new Intl.NumberFormat('fr-FR', { 
                                            style: 'currency', 
                                            currency: 'XOF',
                                            maximumFractionDigits: 0 
                                        }).format(value).replace('XOF', '').trim() + ' FCFA';
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // Graphique des utilisateurs mensuels
            const usersCtx = document.getElementById('monthlyUsersChart');
            if (usersCtx) {
                new Chart(usersCtx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($monthlyUsers['labels']) !!},
                        datasets: [{
                            label: 'Nouveaux utilisateurs',
                            data: {!! json_encode($monthlyUsers['data']) !!},
                            backgroundColor: 'rgba(16, 185, 129, 0.7)',
                            borderColor: 'rgb(16, 185, 129)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endif
</body>
</html>
