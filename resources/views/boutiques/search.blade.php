@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        <div class="w-full md:w-1/4">
            <!-- Filtres de recherche -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Filtrer les résultats</h3>
                
                <!-- Barre de recherche -->
                <form action="{{ route('boutiques.search') }}" method="GET" class="mb-6">
                    <div class="relative">
                        <input type="text" name="q" value="{{ $query }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Rechercher une boutique...">
                        <button type="submit" class="absolute right-2 top-2 text-gray-500 hover:text-blue-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    
                    <!-- Filtre par catégorie -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                        <select name="categorie" onchange="this.form.submit()" 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie }}" {{ $categorie == request('categorie') ? 'selected' : '' }}>
                                    {{ $categorie }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
                
                <!-- Boutiques en vedette -->
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <h4 class="font-medium text-gray-900 mb-3">Boutiques en vedette</h4>
                    <div class="space-y-3">
                        @forelse($boutiquesVedettes as $boutique)
                            <a href="{{ route('boutiques.show', $boutique) }}" class="flex items-center space-x-3 hover:bg-gray-50 p-2 rounded-lg">
                                <div class="flex-shrink-0">
                                    <img src="{{ $boutique->logo ? asset('storage/' . $boutique->logo) : 'https://via.placeholder.com/50' }}" 
                                         alt="{{ $boutique->nom }}" 
                                         class="w-12 h-12 rounded-full object-cover">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $boutique->nom }}</p>
                                    <p class="text-sm text-gray-500 truncate">{{ $boutique->produits_count }} produits</p>
                                </div>
                            </a>
                        @empty
                            <p class="text-sm text-gray-500">Aucune boutique en vedette</p>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <!-- Bannière publicitaire -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-md p-6 text-white text-center">
                <h4 class="font-bold text-lg mb-2">Devenez partenaire</h4>
                <p class="text-sm mb-4">Proposez votre boutique et augmentez vos ventes</p>
                <a href="#" class="inline-block bg-white text-blue-700 hover:bg-gray-100 font-medium py-2 px-4 rounded-full text-sm transition duration-300">
                    En savoir plus
                </a>
            </div>
        </div>
        
        <!-- Contenu principal -->
        <div class="w-full md:w-3/4">
            <!-- En-tête avec résultats -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">
                    {{ $boutiques->total() }} {{ Str::plural('boutique', $boutiques->total()) }} trouvée(s)
                </h1>
                @if($query)
                    <p class="text-gray-600">Résultats pour : <span class="font-medium">{{ $query }}</span></p>
                @endif
                @if(request('categorie'))
                    <p class="text-gray-600">Catégorie : <span class="font-medium">{{ request('categorie') }}</span></p>
                @endif
            </div>
            
            <!-- Liste des boutiques -->
            @if($boutiques->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($boutiques as $boutique)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <div class="relative pb-48 overflow-hidden">
                                <img class="absolute inset-0 h-full w-full object-cover" 
                                     src="{{ $boutique->image ?? 'https://via.placeholder.com/300x200?text=' . urlencode($boutique->nom) }}" 
                                     alt="{{ $boutique->nom }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-4">
                                    <span class="inline-block bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full mb-2">
                                        Jusqu'à {{ rand(10, 30) }}% de cashback
                                    </span>
                                    <h3 class="text-white font-bold text-xl">{{ $boutique->nom }}</h3>
                                </div>
                            </div>
                            <div class="p-4">
                                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($boutique->description, 80) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-900 font-bold">{{ $boutique->categorie }}</span>
                                    <a href="{{ route('boutiques.show', $boutique) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        Voir la boutique <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $boutiques->appends(request()->query())->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <i class="fas fa-store-slash text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Aucune boutique trouvée</h3>
                    <p class="text-gray-500 mb-6">Aucune boutique ne correspond à votre recherche. Essayez d'autres termes ou catégories.</p>
                    <a href="{{ route('boutiques.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-300">
                        Voir toutes les boutiques
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
