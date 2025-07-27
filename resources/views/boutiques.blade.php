@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Nos Boutiques Partenaires</h1>
            <p class="text-xl text-blue-100 mb-8">Découvrez nos boutiques partenaires et profitez de cashback sur tous vos achats</p>
            
            <!-- Barre de recherche -->
            <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg p-1">
                <div class="flex flex-col md:flex-row gap-2">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Rechercher une boutique, une marque ou un secteur">
                    </div>
                    <select class="form-select block w-full md:w-64 px-3 py-3 border border-gray-300 rounded-lg bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Toutes catégories</option>
                        <option value="mode">👕 Mode & Accessoires</option>
                        <option value="alimentation">🍗 Alimentation & Restaurants</option>
                        <option value="high-tech">📱 High-Tech & Électronique</option>
                        <option value="beaute">💅 Beauté & Bien-être</option>
                        <option value="maison">🏠 Maison & Déco</option>
                        <option value="services">🚕 Services & Voyages</option>
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                        Rechercher
                    </button>
                </div>
            </div>
            
            <!-- Statistiques -->
            <div class="flex flex-wrap justify-center gap-8 mt-12">
                <div class="text-center">
                    <div class="text-3xl font-bold">500+</div>
                    <div class="text-blue-200">Boutiques</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold">Jusqu'à 25%</div>
                    <div class="text-blue-200">Cashback</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold">4.8/5</div>
                    <div class="text-blue-200">Avis clients</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="bg-white border-b border-gray-200 py-4">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap items-center gap-3 overflow-x-auto pb-2">
            <span class="text-gray-600 font-medium mr-2 hidden md:block">Filtrer :</span>
            <button class="px-4 py-2 rounded-full bg-blue-600 text-white font-medium text-sm whitespace-nowrap">
                Toutes les boutiques
            </button>
            <button class="px-4 py-2 rounded-full bg-white border border-gray-200 text-gray-700 font-medium text-sm hover:bg-gray-50 whitespace-nowrap">
                <i class="fas fa-star text-yellow-400 mr-1"></i> Meilleur cashback
            </button>
            <button class="px-4 py-2 rounded-full bg-white border border-gray-200 text-gray-700 font-medium text-sm hover:bg-gray-50 whitespace-nowrap">
                <i class="fas fa-bolt text-purple-500 mr-1"></i> Offres spéciales
            </button>
            <button class="px-4 py-2 rounded-full bg-white border border-gray-200 text-gray-700 font-medium text-sm hover:bg-gray-50 whitespace-nowrap">
                <i class="fas fa-gift text-red-500 mr-1"></i> Cadeaux
            </button>
            <button class="px-4 py-2 rounded-full bg-white border border-gray-200 text-gray-700 font-medium text-sm hover:bg-gray-50 whitespace-nowrap">
                <i class="fas fa-truck text-green-500 mr-1"></i> Livraison gratuite
            </button>
        </div>
    </div>
</div>

<!-- Boutiques en vedette -->
<div class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">💎 Boutiques en vedette</h2>
            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                Voir plus <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @for($i = 0; $i < 3; $i++)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="relative">
                    <img src="https://via.placeholder.com/800x400?text=Boutique+Vedette+{{ $i+1 }}" alt="Boutique vedette" class="w-full h-48 object-cover">
                    <div class="absolute top-3 right-3">
                        <button class="bg-white p-2 rounded-full shadow-md hover:bg-gray-100 transition-colors" title="Ajouter aux favoris">
                            <i class="far fa-heart text-red-500"></i>
                        </button>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-black/70 to-transparent">
                        <span class="bg-green-500 text-white text-xs font-semibold px-2.5 py-1 rounded-full">Jusqu'à 15% de cashback</span>
                    </div>
                </div>
                <div class="p-5 text-center">
                    <div class="flex justify-center -mt-12 mb-4">
                        <img src="https://via.placeholder.com/80?text=Logo{{ $i+1 }}" alt="Logo boutique" class="w-16 h-16 rounded-full border-4 border-white shadow-lg">
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Boutique Vedette {{ $i+1 }}</h3>
                    <div class="flex items-center justify-center text-yellow-400 text-sm mb-3">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span class="text-gray-500 ml-2">(256 avis)</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">Découvrez nos offres exclusives et économisez sur vos achats</p>
                    <a href="#" class="inline-block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        Voir les offres
                    </a>
                </div>
            </div>
            @endfor
        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- Toutes les boutiques -->
    <div class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 md:mb-0">🛍️ Toutes nos boutiques</h2>
                <div class="flex items-center space-x-2">
                    <span class="text-gray-600 text-sm">Affichage :</span>
                    <div class="inline-flex rounded-md shadow-sm" role="group">
                        <button type="button" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-l-lg hover:bg-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition-colors">
                            <i class="fas fa-th-large mr-1"></i> Grille
                        </button>
                        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 focus:z-10 focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition-colors">
                            <i class="fas fa-list mr-1"></i> Liste
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @for($i = 0; $i < 12; $i++)
                @php
                    $categories = ['Mode', 'High-Tech', 'Maison', 'Beauté', 'Alimentation', 'Voyages'];
                    $category = $categories[array_rand($categories)];
                    $rating = rand(30, 50) / 10; // Note entre 3.0 et 5.0
                    $reviews = rand(10, 500);
                    $cashback = rand(5, 25);
                @endphp
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="relative">
                        <img src="https://via.placeholder.com/400x200?text={{ urlencode($category) }}+{{ $i+1 }}" alt="Boutique {{ $i+1 }}" class="w-full h-40 object-cover">
                        <div class="absolute top-3 right-3">
                            <button class="bg-white p-2 rounded-full shadow-md hover:bg-gray-100 transition-colors" title="Ajouter aux favoris">
                                <i class="far fa-heart text-red-500"></i>
                            </button>
                        </div>
                        <div class="absolute bottom-0 left-0 w-full p-2 bg-gradient-to-t from-black/70 to-transparent">
                            <span class="bg-green-500 text-white text-xs font-semibold px-2.5 py-1 rounded-full">Jusqu'à {{ $cashback }}% de cashback</span>
                        </div>
                    </div>
                    <div class="p-4 text-center">
                        <div class="flex justify-center -mt-10 mb-3">
                            <img src="https://via.placeholder.com/60?text=Logo{{ $i+1 }}" alt="Logo boutique" class="w-12 h-12 rounded-full border-2 border-white shadow-md bg-white">
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">Boutique {{ $i+1 }}</h3>
                        <div class="flex items-center justify-center space-x-1 mb-2">
                            @for($j = 1; $j <= 5; $j++)
                                @if($j <= floor($rating))
                                    <i class="fas fa-star text-yellow-400 text-sm"></i>
                                @elseif($j - 0.5 <= $rating)
                                    <i class="fas fa-star-half-alt text-yellow-400 text-sm"></i>
                                @else
                                    <i class="far fa-star text-yellow-400 text-sm"></i>
                                @endif
                            @endfor
                            <span class="text-gray-500 text-xs ml-1">({{ $reviews }})</span>
                        </div>
                        <p class="text-gray-600 text-sm mb-3">
                            <i class="fas fa-tag text-blue-500 mr-1"></i> {{ $category }}
                        </p>
                        <a href="#" class="inline-block w-full bg-white border border-blue-600 text-blue-600 hover:bg-blue-50 font-medium py-2 px-4 rounded-lg transition duration-200">
                            Voir les offres
                        </a>
                    </div>
                </div>
                @endfor
            </div>
            
            <!-- Pagination -->
            <div class="mt-10 flex justify-center">
                <nav class="inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <a href="#" class="relative inline-flex items-center px-3 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Précédent</span>
                        <i class="fas fa-chevron-left h-4 w-4"></i>
                    </a>
                    <a href="#" aria-current="page" class="z-10 bg-blue-600 border-blue-600 text-white relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                        1
                    </a>
                    <a href="#" class="bg-white border-gray-300 text-gray-700 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                        2
                    </a>
                    <a href="#" class="bg-white border-gray-300 text-gray-700 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                        3
                    </a>
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                        ...
                    </span>
                    <a href="#" class="bg-white border-gray-300 text-gray-700 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                        10
                    </a>
                    <a href="#" class="relative inline-flex items-center px-3 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Suivant</span>
                        <i class="fas fa-chevron-right h-4 w-4"></i>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Bannière d'inscription -->
<div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h3 class="text-2xl md:text-3xl font-bold mb-4">Prêt à économiser sur vos achats ?</h3>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">Inscrivez-vous dès maintenant et profitez de réductions exclusives et de cashback sur vos boutiques préférées.</p>
        <a href="{{ route('register') }}" class="inline-block bg-white text-blue-700 hover:bg-blue-50 font-bold py-3 px-8 rounded-lg text-lg transition duration-200">
            S'inscrire gratuitement
        </a>
    </div>
</div>

@push('styles')
<style>
    .transition-all {
        transition: all 0.3s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }
    .boutique-card:hover {
        box-shadow: 0 4px 24px rgba(34, 34, 59, 0.15) !important;
        transform: translateY(-2px);
        z-index: 2;
    }
</style>
@endpush

@push('scripts')
<script>
    // Script pour la pagination et les filtres
    document.addEventListener('DOMContentLoaded', function() {
        // Ajouter des écouteurs d'événements pour les boutons de vue (grille/liste)
        const gridViewBtn = document.querySelector('[data-view="grid"]');
        const listViewBtn = document.querySelector('[data-view="list"]');
        const boutiquesContainer = document.querySelector('.boutiques-grid');
        
        if (gridViewBtn && listViewBtn && boutiquesContainer) {
            gridViewBtn.addEventListener('click', () => {
                boutiquesContainer.classList.remove('boutiques-list-view');
                gridViewBtn.classList.add('bg-blue-600', 'text-white');
                gridViewBtn.classList.remove('bg-white', 'text-gray-700');
                listViewBtn.classList.remove('bg-blue-600', 'text-white');
                listViewBtn.classList.add('bg-white', 'text-gray-700');
            });
            
            listViewBtn.addEventListener('click', () => {
                boutiquesContainer.classList.add('boutiques-list-view');
                listViewBtn.classList.add('bg-blue-600', 'text-white');
                listViewBtn.classList.remove('bg-white', 'text-gray-700');
                gridViewBtn.classList.remove('bg-blue-600', 'text-white');
                gridViewBtn.classList.add('bg-white', 'text-gray-700');
            });
        }
    });
</script>
@endpush

@endsection
