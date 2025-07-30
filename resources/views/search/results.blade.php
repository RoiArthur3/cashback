@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Résultats de recherche pour "{{ $query }}"</h1>
    
    @if($produits->count() > 0 || $boutiques->count() > 0)
        @if($produits->count() > 0)
            <section class="mb-12">
                <h2 class="text-xl font-semibold mb-4">Produits ({{ $produits->total() }})</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($produits as $produit)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            @if($produit->image)
                                <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">Pas d'image</span>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-2">{{ $produit->nom }}</h3>
                                <p class="text-gray-600 mb-2">{{ Str::limit($produit->description, 100) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-indigo-600">{{ number_format($produit->prix, 2, ',', ' ') }} €</span>
                                    @if($produit->boutique)
                                        <span class="text-sm text-gray-500">{{ $produit->boutique->nom }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('produits.show', $produit->id) }}" class="block mt-4 text-center bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 transition-colors">
                                    Voir le produit
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $produits->appends(['q' => $query])->links() }}
                </div>
            </section>
        @endif

        @if($boutiques->count() > 0)
            <section>
                <h2 class="text-xl font-semibold mb-4">Boutiques ({{ $boutiques->total() }})</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($boutiques as $boutique)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            @if($boutique->logo)
                                <img src="{{ asset('storage/' . $boutique->logo) }}" alt="{{ $boutique->nom }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">Pas de logo</span>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-2">{{ $boutique->nom }}</h3>
                                <p class="text-gray-600 mb-4">{{ Str::limit($boutique->description, 100) }}</p>
                                <a href="{{ route('boutiques.show', $boutique) }}" class="block text-center bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 transition-colors">
                                    Voir la boutique
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $boutiques->appends(['q' => $query])->links() }}
                </div>
            </section>
        @endif
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <div class="text-5xl mb-4">🔍</div>
            <h2 class="text-xl font-semibold mb-2">Aucun résultat trouvé</h2>
            <p class="text-gray-600">Aucun produit ou boutique ne correspond à votre recherche "{{ $query }}".</p>
            <a href="{{ route('products.index') }}" class="inline-block mt-4 text-indigo-600 hover:text-indigo-800 font-medium">
                Voir tous les produits
            </a>
        </div>
    @endif
</div>
@endsection
