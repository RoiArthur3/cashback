
<header class="bg-gradient-to-r from-blue-900 to-blue-700 text-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4 py-2 flex flex-col md:flex-row items-center justify-between">
        <!-- Menu utilisateur (avant header principal) -->
        <div class="flex items-center space-x-4 order-1 md:order-none mb-2 md:mb-0">
            <div class="relative group">
                <button class="flex items-center space-x-2 p-2 hover:text-yellow-400">
                    <img src="{{ auth()->user() ? auth()->user()->avatar_url : asset('images/default-avatar.png') }}"
                         alt="Mon compte"
                         class="h-8 w-8 rounded-full border-2 border-yellow-400">
                    <span class="hidden md:inline">{{ auth()->user() ? auth()->user()->name : 'Mon compte' }}</span>
                </button>
                <div class="hidden group-hover:block absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-md shadow-lg py-1 z-50">
                    @auth
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-100">Mon profil</a>
                        <a href="{{ route('orders.index') }}" class="block px-4 py-2 hover:bg-gray-100">Mes commandes</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Déconnexion</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-gray-100">Connexion</a>
                        <a href="{{ route('register') }}" class="block px-4 py-2 hover:bg-gray-100">Inscription</a>
                    @endauth
                </div>
            </div>
            <!-- Icône Cagnotte -->
            <a href="{{ route('cagnotte') }}" class="p-2 hover:text-yellow-400" title="Cagnotte">
                <i class="fas fa-wallet text-2xl"></i>
            </a>
        </div>

        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center space-x-2 mb-2 md:mb-0 order-2 md:order-none">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto">
            <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-yellow-400 to-yellow-300">
                Cashback Market
            </span>
        </a>

        <!-- Barre de recherche -->
        <div class="w-full md:w-1/3 mx-4 order-3 md:order-none">
            <form action="{{ route('search') }}" method="GET" class="relative">
                <input type="text"
                       name="q"
                       placeholder="Rechercher des boutiques, articles, bons plans..."
                       class="w-full py-2 px-4 pr-10 rounded-full text-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-yellow-400">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Icônes de navigation -->
        <div class="flex items-center space-x-4 order-4 md:order-none">
            <a href="{{ route('home') }}" class="p-2 hover:text-yellow-400" title="Accueil">
                <i class="fas fa-home text-xl"></i>
            </a>
            <a href="{{ route('boutiques.categories') }}" class="p-2 hover:text-yellow-400" title="Catégories">
                <i class="fas fa-th-large text-xl"></i>
            </a>
            <a href="{{ route('troc.index') }}" class="p-2 hover:text-yellow-400" title="Troc">
                <i class="fas fa-exchange-alt text-xl"></i>
            </a>
            <a href="{{ route('deals') }}" class="p-2 hover:text-yellow-400" title="Bons plans">
                <i class="fas fa-tags text-xl"></i>
            </a>
            <a href="{{ route('notifications.index') }}" class="p-2 hover:text-yellow-400 relative" title="Notifications">
                <i class="far fa-bell text-xl"></i>
                <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">2</span>
            </a>
        </div>
    </div>

    <!-- Navigation secondaire -->
    <nav class="bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="flex space-x-6 overflow-x-auto py-2 hide-scrollbar">
                <a href="{{ route('boutiques.index') }}" class="whitespace-nowrap px-3 py-2 text-sm font-medium hover:bg-gray-800 rounded">
                    Toutes les boutiques
                </a>
                <a href="{{ route('boutiques.categories') }}" class="whitespace-nowrap px-3 py-2 text-sm font-medium hover:bg-gray-800 rounded">
                    Catégories
                </a>
                <a href="{{ route('nouveautes') }}" class="whitespace-nowrap px-3 py-2 text-sm font-medium hover:bg-gray-800 rounded">
                    Nouveautés
                </a>
                <a href="{{-- {{ route('top-offres') }} --}}" class="whitespace-nowrap px-3 py-2 text-sm font-medium hover:bg-gray-800 rounded">
                    Top offres
                </a>
            </div>
        </div>
    </nav>
</header>

<style>
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
.hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
