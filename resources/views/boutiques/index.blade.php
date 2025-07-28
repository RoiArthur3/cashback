@extends('layouts.app')

@push('styles')
<style>
    .boutique-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 0.75rem;
        overflow: hidden;
        background: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .boutique-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .boutique-logo {
        height: 180px;
    }
</style>
@endpush

@section('content')
<!-- Inclure les modales -->
@include('boutiques._modal')
@include('boutiques._produit_modal')
<!-- Bannière principale avec recherche -->
<div class="bg-gradient-to-r from-blue-700 to-blue-900 py-10 md:py-16">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 text-center md:text-left mb-6 md:mb-0">
                <h1 class="text-2xl md:text-4xl font-extrabold text-white mb-3">Nos boutiques partenaires</h1>
                <p class="text-blue-100">Découvrez nos partenaires et profitez de cashback sur vos achats</p>
            </div>
            
            <!-- Barre de recherche -->
            <div class="w-full md:w-1/2">
                <form action="{{ route('boutiques.search') }}" method="GET" class="bg-white rounded-lg shadow-lg p-1">
                    <div class="flex">
                        <input type="text" name="q" value="{{ request('q') }}" class="w-full px-4 py-3 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Rechercher une boutique...">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-r-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="bg-white shadow-sm sticky top-0 z-10">
    <div class="container mx-auto px-4 py-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex-1">
                <form action="{{ route('boutiques.index') }}" method="GET" class="flex">
                    <select name="categorie" onchange="this.form.submit()" class="w-full md:w-auto border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>
                    
                    <select name="trier_par" onchange="this.form.submit()" class="ml-2 border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="populaires" {{ request('trier_par') == 'populaires' ? 'selected' : '' }}>Populaires</option>
                        <option value="nouveautes" {{ request('trier_par') == 'nouveautes' ? 'selected' : '' }}>Nouveautés</option>
                        <option value="cashback_eleve" {{ request('trier_par') == 'cashback_eleve' ? 'selected' : '' }}>Cashback élevé</option>
                        <option value="notes_elevees" {{ request('trier_par') == 'notes_elevees' ? 'selected' : '' }}>Notes élevées</option>
                    </select>
                    
                    @if(request()->hasAny(['q', 'categorie', 'trier_par']))
                        <a href="{{ route('boutiques.index') }}" class="ml-2 flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            <i class="fas fa-times mr-1"></i> Réinitialiser
                        </a>
                    @endif
                </form>
            </div>
            
            <div class="text-sm text-gray-500">
                {{ $boutiques->total() }} {{ $boutiques->total() > 1 ? 'boutiques trouvées' : 'boutique trouvée' }}
            </div>
        </div>
    </div>
</div>

<!-- Liste des boutiques -->
<div class="container mx-auto px-4 py-8">
    @if($boutiques->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($boutiques as $boutique)
                <div class="boutique-card">
                    <a href="{{ route('boutiques.show', ['id' => $boutique->id, 'slug' => $boutique->slug]) }}" class="block">
                        <div class="boutique-logo">
                            @if($boutique->logo)
                                <img src="{{ asset('storage/' . $boutique->logo) }}" alt="{{ $boutique->nom }}" class="max-h-full">
                            @else
                                <div class="text-4xl font-bold text-gray-400">{{ substr($boutique->nom, 0, 1) }}</div>
                            @endif
                        </div>
                        <div class="boutique-details">
                            <h3 class="boutique-name">{{ $boutique->nom }}</h3>
                            @if($boutique->description)
                                <p class="boutique-description">{{ $boutique->description }}</p>
                            @endif
                            <div class="boutique-meta">
                                <span class="cashback-badge">
                                    Jusqu'à {{ $boutique->cashback_max }}% de cashback
                                </span>
                                @if($boutique->note_moyenne > 0)
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <span class="ml-1">{{ number_format($boutique->note_moyenne, 1) }}</span>
                                        <span class="rating-count">({{ $boutique->nb_avis }})</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                        <div class="bg-white/20 rounded-full w-8 h-8 flex items-center justify-center mr-3 flex-shrink-0">
                            <span class="text-white font-bold">3</span>
                        </div>
                        <p class="text-white text-sm">Validez la réception pour activer votre cashback</p>
                    </div>
                </div>
            </div>
            <div class="md:w-1/4 text-center">
                <div class="bg-white/20 backdrop-blur-sm p-4 rounded-lg">
                    <p class="text-white text-sm mb-2">Cashback garanti après livraison</p>
                    <span class="inline-block bg-white text-green-600 font-bold py-1 px-3 rounded-full text-sm">
                        Jusqu'à 30%
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="mb-6 flex flex-col md:flex-row justify-between items-center">
        <div class="mb-4 md:mb-0">
            <h2 class="text-2xl font-bold text-gray-800">Produits disponibles</h2>
            <p class="text-gray-600 text-sm">Commandez maintenant, payez à la livraison</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <select class="block appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Trier par : Pertinence</option>
                    <option>Prix croissant</option>
                    <option>Prix décroissant</option>
                    <option>Cashback le plus élevé</option>
                    <option>Meilleures ventes</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                <i class="fas fa-filter mr-2"></i> Filtres
            </button>
        </div>
    </div>

    <!-- Liste des produits -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @php
            $produits = [
                [
                    'nom' => 'Smartphone X Pro',
                    'boutique' => 'TechShop',
                    'prix' => 899.99,
                    'prix_barre' => 1099.99,
                    'cashback' => 8.5,
                    'image' => 'https://images.unsplash.com/photo-1511707171639-5f897ff02aa9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'livraison' => 'Livraison en 3-5 jours',
                    'categorie' => 'High-Tech',
                    'note' => 4.7,
                    'avis' => 1245,
                    'stock' => 15,
                    'livraison_gratuite' => true,
                    'nouveaute' => true,
                    'top_vente' => false
                ],
                [
                    'nom' => 'Baskets Sport Pro',
                    'boutique' => 'SportPlus',
                    'prix' => 89.99,
                    'prix_barre' => 129.99,
                    'cashback' => 12.5,
                    'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'livraison' => 'Livraison en 2-4 jours',
                    'categorie' => 'Mode',
                    'note' => 4.5,
                    'avis' => 876,
                    'stock' => 42,
                    'livraison_gratuite' => true,
                    'nouveaute' => false,
                    'top_vente' => true
                ],
                [
                    'nom' => 'Casque Audio Sans Fil',
                    'boutique' => 'AudioPro',
                    'prix' => 149.99,
                    'prix_barre' => 199.99,
                    'cashback' => 15.0,
                    'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'livraison' => 'Livraison en 3-5 jours',
                    'categorie' => 'Audio',
                    'note' => 4.8,
                    'avis' => 2156,
                    'stock' => 28,
                    'livraison_gratuite' => true,
                    'nouveaute' => true,
                    'top_vente' => false
                ],
                [
                    'nom' => 'Montre Connectée Pro',
                    'boutique' => 'TechShop',
                    'prix' => 199.99,
                    'prix_barre' => 249.99,
                    'cashback' => 10.0,
                    'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'livraison' => 'Livraison en 2-3 jours',
                    'categorie' => 'High-Tech',
                    'note' => 4.6,
                    'avis' => 1567,
                    'stock' => 0,
                    'livraison_gratuite' => true,
                    'nouveaute' => true,
                    'top_vente' => false
                ],
                [
                    'nom' => 'Sac à Dos Urbain',
                    'boutique' => 'UrbanStyle',
                    'prix' => 49.99,
                    'prix_barre' => 79.99,
                    'cashback' => 20.0,
                    'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'livraison' => 'Livraison en 1-3 jours',
                    'categorie' => 'Mode',
                    'note' => 4.4,
                    'avis' => 543,
                    'stock' => 36,
                    'livraison_gratuite' => false,
                    'nouveaute' => true,
                    'top_vente' => false
                ],
                [
                    'nom' => 'Enceinte Bluetooth',
                    'boutique' => 'AudioPro',
                    'prix' => 129.99,
                    'prix_barre' => 159.99,
                    'cashback' => 8.0,
                    'image' => 'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'livraison' => 'Livraison en 2-4 jours',
                    'categorie' => 'Audio',
                    'note' => 4.3,
                    'avis' => 876,
                    'stock' => 22,
                    'livraison_gratuite' => true,
                    'nouveaute' => false,
                    'top_vente' => true
                ],
                [
                    'nom' => 'Lunettes de Soleil Premium',
                    'boutique' => 'FashionStyle',
                    'prix' => 159.99,
                    'prix_barre' => 199.99,
                    'cashback' => 12.0,
                    'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237ac008?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'livraison' => 'Livraison en 3-6 jours',
                    'categorie' => 'Mode',
                    'note' => 4.7,
                    'avis' => 342,
                    'stock' => 18,
                    'livraison_gratuite' => true,
                    'nouveaute' => true,
                    'top_vente' => false
                ],
                [
                    'nom' => 'Ordinateur Portable Ultrabook',
                    'boutique' => 'TechShop',
                    'prix' => 1299.99,
                    'prix_barre' => 1499.99,
                    'cashback' => 5.5,
                    'image' => 'https://images.unsplash.com/photo-1611186871348-b1ce696e5c09?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'livraison' => 'Livraison en 4-7 jours',
                    'categorie' => 'Informatique',
                    'note' => 4.9,
                    'avis' => 2897,
                    'stock' => 8,
                    'livraison_gratuite' => true,
                    'nouveaute' => false,
                    'top_vente' => true
                ]
            ];
        @endphp

        @foreach($produits as $index => $produit)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 cursor-pointer"
             onclick="openProductModal({
                id: '{{ $index + 1 }}',
                nom: '{{ addslashes($produit['nom']) }}',
                boutique: '{{ addslashes($produit['boutique']) }}',
                prix: {{ $produit['prix'] }},
                prix_barre: {{ $produit['prix_barre'] ?? $produit['prix'] * 1.2 }},
                cashback: {{ $produit['cashback'] }},
                description: '{{ addslashes($produit['description'] ?? 'Découvrez ce produit exclusif avec un cashback exceptionnel. Profitez de la livraison rapide et du paiement sécurisé.') }}',
                note: {{ $produit['note'] ?? 4.5 }},
                avis: {{ $produit['avis'] ?? rand(10, 500) }},
                stock: {{ $produit['stock'] ?? 1 }},
                livraison_gratuite: {{ $produit['livraison_gratuite'] ?? true ? 'true' : 'false' }},
                nouveaute: {{ $produit['nouveaute'] ?? false ? 'true' : 'false' }},
                top_vente: {{ $produit['top_vente'] ?? false ? 'true' : 'false' }},
                categorie: '{{ addslashes($produit['categorie'] ?? 'Général') }}',
                marque: '{{ addslashes($produit['marque'] ?? $produit['boutique']) }}',
                reference: 'REF-{{ strtoupper(substr($produit['boutique'], 0, 3)) }}-{{ str_pad($index + 1, 4, '0', STR_PAD_LEFT) }}',
                poids: {{ rand(5, 50) / 10 }},
                dimensions: '15 x 10 x 5 cm',
                images: [
                    '{{ $produit['image'] ?? 'https://via.placeholder.com/500' }}',
                    'https://images.unsplash.com/photo-1494972308805-463bc619d34e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1526170375885-4edd8f878829?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1515955656352-a1fa3ffcd111?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
                ]
             })">
            <!-- Badges -->
            <div class="absolute top-3 left-3 flex flex-col space-y-2">
                @if($produit['nouveaute'])
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    Nouveauté
                </span>
                @endif
                @if($produit['top_vente'])
                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    Top vente
                </span>
                @endif
                @if($produit['cashback'] >= 15)
                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $produit['cashback'] }}% cashback
                </span>
                @elseif($produit['cashback'] >= 10)
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $produit['cashback'] }}% cashback
                </span>
                @else
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $produit['cashback'] }}% cashback
                </span>
                @endif
            </div>
            
            <!-- Image du produit -->
            <div class="relative pb-[100%] bg-gray-100">
                <img class="absolute inset-0 h-full w-full object-cover hover:scale-105 transition-transform duration-500" 
                     src="{{ $produit['image'] }}" 
                     alt="{{ $produit['nom'] }}">
                <!-- Bouton favori -->
                <button class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 text-gray-600 hover:text-red-500 transition-colors">
                    <i class="far fa-heart text-lg"></i>
                </button>
            </div>
            
            <!-- Détails du produit -->
            <div class="p-4">
                <!-- Boutique -->
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-500">{{ $produit['boutique'] }}</span>
                    <div class="flex items-center">
                        <i class="fas fa-star text-yellow-400 text-sm mr-1"></i>
                        <span class="text-sm font-medium text-gray-900">{{ $produit['note'] }}</span>
                        <span class="mx-1 text-gray-300">|</span>
                        <span class="text-xs text-gray-500">{{ $produit['avis'] }} avis</span>
                    </div>
                </div>
                
                <!-- Nom du produit -->
                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                    {{ $produit['nom'] }}
                </h3>
                
                <!-- Prix -->
                <div class="mb-3">
                    <div class="flex items-baseline">
                        <span class="text-2xl font-bold text-gray-900">{{ number_format($produit['prix'], 2, ',', ' ') }} €</span>
                        @if($produit['prix_barre'] > $produit['prix'])
                        <span class="ml-2 text-sm text-gray-500 line-through">{{ number_format($produit['prix_barre'], 2, ',', ' ') }} €</span>
                        @endif
                    </div>
                    <div class="flex items-center mt-1">
                        <span class="text-sm font-medium text-green-600">
                            Économisez {{ number_format($produit['prix_barre'] - $produit['prix'], 2, ',', ' ') }} €
                        </span>
                    </div>
                </div>
                
                <!-- Livraison -->
                <div class="flex items-center text-sm text-gray-600 mb-4">
                    @if($produit['livraison_gratuite'])
                    <i class="fas fa-truck text-green-500 mr-2"></i>
                    <span>Livraison gratuite</span>
                    @else
                    <i class="fas fa-truck text-gray-400 mr-2"></i>
                    <span>Frais de livraison à partir de 3,99 €</span>
                    @endif
                </div>
                
                <!-- Bouton d'action -->
                @if($produit['stock'] > 0)
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    <span>Commander maintenant</span>
                </button>
                <p class="mt-2 text-xs text-center text-gray-500">Paiement à la livraison</p>
                @else
                <button class="w-full bg-gray-300 text-gray-600 font-medium py-2 px-4 rounded-lg cursor-not-allowed" disabled>
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>Rupture de stock</span>
                </button>
                @endif
                
                <!-- Cashback -->
                <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-600">Cashback après livraison</p>
                            <p class="text-lg font-bold text-blue-700">{{ $produit['cashback'] }}%</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-600">Soit jusqu'à</p>
                            <p class="text-lg font-bold text-blue-700">{{ number_format(($produit['prix'] * $produit['cashback'] / 100), 2, ',', ' ') }} €</p>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Crédité après validation de la réception</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Section "Comment ça marche ?" -->
    <div class="mb-12 bg-gradient-to-r from-blue-700 to-blue-900 rounded-xl shadow-lg overflow-hidden">
        <div class="p-8 md:p-12">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-6">Comment gagner avec Cashback Market ?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
                    <!-- Étape 1 -->
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm p-6 rounded-xl">
                        <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-4 mx-auto">1</div>
                        <h3 class="text-xl font-semibold text-white mb-3">Choisissez vos produits</h3>
                        <p class="text-blue-100">Parcourez nos boutiques partenaires et sélectionnez vos articles préférés.</p>
                    </div>
                    
                    <!-- Étape 2 -->
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm p-6 rounded-xl">
                        <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-4 mx-auto">2</div>
                        <h3 class="text-xl font-semibold text-white mb-3">Commandez en ligne</h3>
                        <p class="text-blue-100">Passez commande directement sur notre plateforme sécurisée.</p>
                    </div>
                    
                    <!-- Étape 3 -->
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm p-6 rounded-xl">
                        <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-4 mx-auto">3</div>
                        <h3 class="text-xl font-semibold text-white mb-3">Recevez votre cashback</h3>
                        <p class="text-blue-100">Payez à la livraison et recevez votre cashback directement sur votre compte.</p>
                    </div>
                </div>
                
                <div class="mt-10">
                    <a href="#" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 md:py-4 md:text-lg md:px-10 transition duration-300">
                        Découvrir comment ça marche
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-12 flex items-center justify-between border-t border-gray-200 px-4 py-3 sm:px-6">
        <div class="flex flex-1 justify-between sm:hidden">
            <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Précédent</a>
            <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Suivant</a>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Affichage de <span class="font-medium">1</span> à <span class="font-medium">8</span> sur <span class="font-medium">42</span> résultats
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <a href="#" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Précédent</span>
                        <i class="fas fa-chevron-left h-5 w-5"></i>
                    </a>
                    <a href="#" aria-current="page" class="relative z-10 inline-flex items-center bg-blue-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">1</a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">2</a>
                    <a href="#" class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex">3</a>
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                    <a href="#" class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex">8</a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">9</a>
                    <a href="#" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Suivant</span>
                        <i class="fas fa-chevron-right h-5 w-5"></i>
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Newsletter -->
    <div class="mt-16 bg-gradient-to-r from-blue-800 to-indigo-900 rounded-2xl shadow-xl overflow-hidden">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center">
            <div class="lg:w-0 lg:flex-1">
                <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    Recevez nos meilleures offres
                </h2>
                <p class="mt-3 max-w-3xl text-lg leading-6 text-blue-100">
                    Inscrivez-vous à notre newsletter pour ne rien manquer des promotions et des bons plans exclusifs.
                </p>
            </div>
            <div class="mt-8 lg:mt-0 lg:ml-8">
                <form class="sm:flex">
                    <label for="email-address" class="sr-only">Adresse email</label>
                    <input id="email-address" name="email" type="email" autocomplete="email" required 
                           class="w-full px-5 py-3 border border-transparent placeholder-gray-500 focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-800 focus:ring-white focus:border-white sm:max-w-xs rounded-md" 
                           placeholder="Votre adresse email">
                    <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3 sm:flex-shrink-0">
                        <button type="submit" class="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-800 focus:ring-white">
                            S'abonner
                        </button>
                    </div>
                </form>
                <p class="mt-3 text-sm text-blue-100">
                    En vous inscrivant, vous acceptez notre politique de confidentialité.
                </p>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
// Fonction pour ouvrir la modale d'une boutique
function openBoutique(boutique) {
    // Préparer les données de la boutique pour la modale
    const boutiqueData = {
        id: boutique.id || 1,
        nom: boutique.nom || 'Boutique Partenaire',
        logo: boutique.logo || 'https://via.placeholder.com/150',
        categorie: boutique.categorie || 'Mode',
        note: boutique.note || 4.5,
        avis: boutique.avis || 128,
        cashback: boutique.cashback || 5.5,
        description: boutique.description || 'Découvrez notre sélection exclusive de produits avec cashback.',
        livraison: boutique.livraison || 'Livraison sous 2-4 jours',
        url: boutique.url || '#'
    };
    
    // Ouvrir la modale avec les données de la boutique
    if (window.BoutiqueModal && typeof window.BoutiqueModal.open === 'function') {
        window.BoutiqueModal.open(boutiqueData);
    }
    
    // Charger les produits de la boutique
    loadProduitsBoutique(boutiqueData.id);
}

// Fonction pour ouvrir la modale d'un produit
function openProductModal(produit) {
    // Ouvrir la modale avec les données du produit
    if (window.ProduitModal && typeof window.ProduitModal.open === 'function') {
        window.ProduitModal.open(produit);
    }
}

// Fonction pour charger les produits d'une boutique
function loadProduitsBoutique(boutiqueId) {
    // Ici, vous feriez normalement un appel AJAX pour récupérer les produits de la boutique
    // Pour l'exemple, nous allons utiliser des données simulées
    const produitsSimules = [
        {
            id: 1,
            nom: 'Produit Premium',
            prix: 129.99,
            prix_barre: 159.99,
            cashback: 8.5,
            image: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            stock: 15,
            note: 4.7,
            avis: 1245,
            livraison_gratuite: true,
            nouveaute: true,
            top_vente: true,
            categorie: 'Mode',
            marque: 'Marque Premium',
            description: 'Découvrez ce produit exclusif avec un design moderne et des matériaux de haute qualité.',
            images: [
                'https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'https://images.unsplash.com/photo-1494972308805-463bc619d34e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'https://images.unsplash.com/photo-1526170375885-4edd8f878829?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
            ]
        },
        // Ajoutez d'autres produits simulés si nécessaire
    ];
    
    // Afficher les produits dans la modale
    afficherProduits(produitsSimules);
}

// Fonction pour afficher les produits dans la modale de la boutique
function afficherProduits(produits) {
    const produitsContainer = document.getElementById('produitsBoutique');
    
    if (!produitsContainer) return;
    
    if (produits.length === 0) {
        produitsContainer.innerHTML = `
            <div class="col-span-2 text-center py-10">
                <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Aucun produit disponible pour le moment</p>
            </div>
        `;
        return;
    }
    
    // Créer les cartes de produits
    const produitsHTML = produits.map(produit => `
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300 cursor-pointer"
             onclick="event.stopPropagation(); openProductModal(${JSON.stringify(produit).replace(/"/g, '&quot;')})">
            <div class="relative pb-2/3">
                <img src="${produit.image}" alt="${produit.nom}" class="absolute h-full w-full object-cover">
                ${produit.stock ? '' : '<div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center"><span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">Rupture</span></div>'}
                
                <!-- Badges -->
                <div class="absolute top-2 left-2 space-y-1">
                    ${produit.nouveaute ? '<span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded-full">Nouveauté</span>' : ''}
                    ${produit.top_vente ? '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-0.5 rounded-full">Top vente</span>' : ''}
                </div>
                
                <!-- Cashback -->
                <div class="absolute top-2 right-2">
                    <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded-full">
                        ${produit.cashback}% cashback
                    </span>
                </div>
            </div>
            <div class="p-4">
                <h5 class="font-semibold text-gray-900 mb-1 line-clamp-2">${produit.nom}</h5>
                <div class="flex items-center justify-between mt-2">
                    <div>
                        <span class="text-lg font-bold text-blue-600">${produit.prix.toFixed(2)} €</span>
                        ${produit.prix_barre > produit.prix ? `<span class="ml-2 text-sm text-gray-500 line-through">${produit.prix_barre.toFixed(2)} €</span>` : ''}
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                        <span class="text-sm text-gray-700 ml-1">${produit.note}</span>
                        <span class="text-xs text-gray-500 ml-1">(${produit.avis})</span>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-xs text-green-600 font-medium">
                        <i class="fas fa-coins mr-1"></i>
                        Jusqu'à ${(produit.prix * produit.cashback / 100).toFixed(2)} € de cashback
                    </span>
                </div>
            </div>
        </div>
    `).join('');
    
    produitsContainer.innerHTML = produitsHTML;
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Ajouter des écouteurs d'événements pour les boutons de boutique
    document.querySelectorAll('.boutique-item').forEach(bouton => {
        bouton.addEventListener('click', function() {
            const boutiqueData = {
                id: this.dataset.id,
                nom: this.dataset.nom,
                logo: this.dataset.logo,
                categorie: this.dataset.categorie,
                note: parseFloat(this.dataset.note) || 0,
                avis: parseInt(this.dataset.avis) || 0,
                cashback: parseFloat(this.dataset.cashback) || 0,
                description: this.dataset.description,
                livraison: this.dataset.livraison,
                url: this.dataset.url
            };
            openBoutique(boutiqueData);
        });
    });
});
</script>
