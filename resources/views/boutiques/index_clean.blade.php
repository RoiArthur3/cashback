@extends('layouts.app')

@push('styles')
<style>
    .shop-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .shop-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Hero Section -->
    <div class="text-center mb-12">
        <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
            Nos Boutiques Partenaires
        </h1>
        <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
            Découvrez nos boutiques partenaires et profitez de cashback sur vos achats
        </p>
    </div>

    <!-- Barre de recherche -->
    <div class="max-w-4xl mx-auto mb-12">
        <form method="GET" action="{{ route('boutiques.index') }}" class="space-y-4">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="recherche" value="{{ request('recherche') }}" 
                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="Rechercher une boutique, une marque ou un secteur">
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 whitespace-nowrap">
                    <i class="fas fa-search mr-2"></i> Rechercher
                </button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <select name="categorie" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Toutes catégories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('categorie') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <input type="number" name="prix_max" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                           placeholder="Prix max" value="{{ request('prix_max') }}">
                </div>
                <div>
                    <input type="number" name="cashback_min" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                           placeholder="% Cashback min" value="{{ request('cashback_min') }}">
                </div>
            </div>
        </form>
    </div>

    <!-- Meilleure offre -->
    @if(!$boutiques->isEmpty())
        @php
            $bestCashback = $boutiques->sortByDesc('taux_cashback')->first();
        @endphp
        <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-xl shadow-xl overflow-hidden mb-12 transform transition-all duration-300 hover:shadow-2xl">
            <div class="p-8">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/3 mb-6 md:mb-0 md:pr-8">
                        <span class="inline-block bg-white text-yellow-700 text-xs font-bold px-3 py-1 rounded-full mb-3">MEILLEURE OFFRE DU MOMENT</span>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $bestCashback->nom }}</h3>
                        <div class="flex items-center text-yellow-700 mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($bestCashback->note_moyenne ?? 0))
                                    <i class="fas fa-star"></i>
                                @elseif($i == ceil($bestCashback->note_moyenne ?? 0) && ($bestCashback->note_moyenne ?? 0) != floor($bestCashback->note_moyenne ?? 0))
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                            <span class="ml-2 text-gray-800 font-medium">{{ number_format($bestCashback->note_moyenne ?? 0, 1) }} ({{ $bestCashback->avis_count ?? 0 }} avis)</span>
                        </div>
                        <p class="text-gray-800 mb-6">{{ $bestCashback->description ?? 'Profitez de cette offre exceptionnelle' }}</p>
                        <a href="{{ route('boutiques.show', $bestCashback) }}" class="inline-flex items-center px-6 py-3 bg-white text-yellow-700 font-bold rounded-lg shadow-md hover:bg-gray-100 transition duration-200">
                            Voir l'offre exclusive
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="md:w-2/3">
                        <div class="bg-white bg-opacity-30 backdrop-blur-sm p-6 rounded-lg">
                            <div class="text-center mb-4">
                                <span class="text-5xl font-bold text-gray-900">{{ number_format($bestCashback->taux_cashback, 0) }}%</span>
                                <p class="text-lg font-semibold text-gray-800">de cashback</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-6">
                                <div class="bg-white bg-opacity-70 p-4 rounded-lg text-center">
                                    <div class="text-2xl font-bold text-yellow-600">+{{ rand(100, 500) }}</div>
                                    <div class="text-sm text-gray-700">Utilisateurs satisfaits</div>
                                </div>
                                <div class="bg-white bg-opacity-70 p-4 rounded-lg text-center">
                                    <div class="text-2xl font-bold text-yellow-600">{{ number_format($bestCashback->produits_count) }}+</div>
                                    <div class="text-sm text-gray-700">Produits disponibles</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Grille des boutiques -->
    <div class="mb-12">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-900">Toutes nos boutiques</h2>
            <div class="w-full sm:w-auto flex items-center space-x-2">
                <span class="text-sm text-gray-500 whitespace-nowrap">Trier par :</span>
                <select class="w-full sm:w-auto border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Meilleur cashback</option>
                    <option>Meilleure note</option>
                    <option>Ordre alphabétique</option>
                    <option>Nouveautés</option>
                </select>
            </div>
        </div>

        @if($boutiques->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($boutiques as $boutique)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 shop-card">
                        <!-- Badge de statut -->
                        @if($boutique->statut === 'nouveau')
                            <div class="absolute top-3 left-3 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full z-10">
                                NOUVEAU
                            </div>
                        @endif
                        
                        <!-- Image de la boutique -->
                        <div class="relative h-48 bg-gray-100 overflow-hidden">
                            @if($boutique->image)
                                <img src="{{ asset('storage/' . $boutique->image) }}" alt="{{ $boutique->nom }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100">
                                    <svg class="h-16 w-16 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Badge de cashback -->
                            <div class="absolute bottom-3 right-3 bg-yellow-400 text-yellow-900 text-sm font-bold px-3 py-1 rounded-full shadow-md">
                                {{ number_format($boutique->taux_cashback, 0) }}% CASHBACK
                            </div>
                        </div>
                        
                        <!-- Détails de la boutique -->
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold text-gray-900">{{ $boutique->nom }}</h3>
                                <button type="button" class="text-gray-400 hover:text-red-500 transition-colors" title="Ajouter aux favoris">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Note et avis -->
                            <div class="flex items-center mb-3">
                                <div class="flex items-center text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($boutique->note_moyenne ?? 0))
                                            <i class="fas fa-star"></i>
                                        @elseif($i == ceil($boutique->note_moyenne ?? 0) && ($boutique->note_moyenne ?? 0) != floor($boutique->note_moyenne ?? 0))
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                    <span class="ml-2 text-sm text-gray-600">{{ number_format($boutique->note_moyenne ?? 0, 1) }} ({{ $boutique->avis_count ?? 0 }} avis)</span>
                                </div>
                            </div>
                            
                            <!-- Description courte -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{ $boutique->description_breve ?? 'Découvrez nos offres exclusives sur cette boutique partenaire.' }}
                            </p>
                            
                            <!-- Bouton Voir la boutique -->
                            <a href="{{ route('boutiques.show', $boutique) }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                                Voir la boutique
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($boutiques->hasPages())
                <div class="mt-12">
                    {{ $boutiques->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-16 bg-white rounded-xl shadow-sm">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4.5 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Aucune boutique trouvée</h3>
                <p class="mt-1 text-gray-500">Aucune boutique ne correspond à votre recherche. Essayez d'autres termes ou catégories.</p>
                <div class="mt-6">
                    <a href="{{ route('boutiques.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Réinitialiser la recherche
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Scripts spécifiques à la page des boutiques
    document.addEventListener('DOMContentLoaded', function() {
        // Animation des cartes au chargement
        const cards = document.querySelectorAll('.shop-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100 * index);
        });
    });
</script>
@endpush
@endsection
