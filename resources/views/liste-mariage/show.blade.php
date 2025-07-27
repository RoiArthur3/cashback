@extends('layouts.app')

@section('title', $liste->titre)

@push('styles')
<style>
    /* Fond de cœurs */
    .hearts-bg {
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M50 85l-5.9-5.3C30.1 68.6 20 58.6 20 45.9c0-10.4 8.5-18.9 19-18.9 5.3 0 10.4 2.4 13.8 6.5 3.4-4.1 8.5-6.5 13.8-6.5 10.5 0 19 8.5 19 18.9 0 12.7-10.1 22.7-24.1 33.8L50 85z' fill='%23f9a8d4' fill-opacity='0.1'/%3E%3C/svg%3E");
        position: relative;
        z-index: 1;
    }
    
    .hearts-bg::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255, 240, 245, 0.9) 0%, rgba(255, 230, 240, 0.95) 100%);
        z-index: -1;
    }
    
    .theme-gradient {
        background: linear-gradient(135deg, #f9a8d4 0%, #ec4899 100%);
    }
    .theme-text {
        color: {{ $liste->couleur_principale }};
    }
    .theme-border {
        border-color: {{ $liste->couleur_principale }};
    }
    .theme-bg {
        background-color: {{ $liste->couleur_principale }};
    }
    .theme-hover:hover {
        background-color: {{ $liste->couleur_principale }};
        border-color: {{ $liste->couleur_principale }};
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 hearts-bg">
    <!-- En-tête avec image de couverture -->
    <div class="relative">
        @if($liste->image_couverture)
            <div class="h-64 w-full bg-gray-200 overflow-hidden">
                <img src="{{ Storage::url($liste->image_couverture) }}" alt="{{ $liste->titre }}" class="w-full h-full object-cover">
            </div>
        @else
            <div class="h-64 w-full theme-gradient flex items-center justify-center">
                <div class="text-center text-white px-4">
                    <h1 class="text-4xl font-bold mb-2">{{ $liste->titre }}</h1>
                    <p class="text-xl opacity-90">Liste de mariage de {{ $liste->user->name }}</p>
                    <div class="mt-4">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-white bg-opacity-20 text-white">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            {{ $liste->date_mariage->format('d/m/Y') }}
                        </span>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Bouton de partage -->
        <div class="absolute top-4 right-4">
            <button id="partagerBtn" class="p-2 rounded-full bg-white bg-opacity-90 text-gray-700 hover:bg-opacity-100 shadow-md">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                </svg>
            </button>
            
            <!-- Menu de partage (caché par défaut) -->
            <div id="menuPartage" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 z-10">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fab fa-facebook mr-2"></i> Partager sur Facebook
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fab fa-whatsapp mr-2"></i> Partager sur WhatsApp
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-envelope mr-2"></i> Envoyer par email
                </a>
                <div class="border-t border-gray-100 my-1"></div>
                <div class="px-4 py-2">
                    <div class="flex items-center">
                        <input type="text" id="lienPartage" readonly value="{{ route('liste-mariage.show', $liste) }}" class="flex-1 text-xs border border-gray-300 rounded-l-md px-2 py-1 focus:outline-none focus:ring-1 focus:ring-amber-500">
                        <button onclick="copierLien()" class="bg-gray-100 border border-l-0 border-gray-300 rounded-r-md px-2 py-1 text-xs text-gray-600 hover:bg-gray-200">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Contenu principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:flex lg:space-x-8">
            <!-- Colonne principale -->
            <div class="lg:w-2/3">
                <!-- En-tête -->
                <div class="mb-8">
                    @if($liste->image_couverture)
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $liste->titre }}</h1>
                        <p class="text-gray-600 mb-4">Liste de mariage de {{ $liste->user->name }}</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $liste->date_mariage->format('d/m/Y') }}</span>
                            
                            @if($liste->theme)
                                <span class="mx-2">•</span>
                                <span>{{ ucfirst($liste->theme) }}</span>
                            @endif
                        </div>
                    @endif
                    
                    @if($liste->description)
                        <div class="mt-4 text-gray-700">
                            {{ $liste->description }}
                        </div>
                    @endif
                    
                    <!-- Barre de progression -->
                    @php
                        $totalProduits = $liste->produits->count();
                        $produitsReserves = $liste->produits->where('pivot.statut', 'reserve')->count();
                        $pourcentage = $totalProduits > 0 ? round(($produitsReserves / $totalProduits) * 100) : 0;
                    @endphp
                    
                    <div class="mt-6">
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Progression de la liste</span>
                            <span>{{ $produitsReserves }} sur {{ $totalProduits }} articles ({{ $pourcentage }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-amber-500 h-2.5 rounded-full" style="width: {{ $pourcentage }}%"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Filtres et tris -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-3 sm:space-y-0">
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" id="rechercheProduit" placeholder="Rechercher un produit..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                    </div>
                    
                    <div class="flex items-center space-x-2 w-full sm:w-auto">
                        <label for="trierPar" class="text-sm text-gray-600 whitespace-nowrap">Trier par :</label>
                        <select id="trierPar" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-1 focus:ring-amber-500 focus:border-amber-500 sm:text-sm rounded-md">
                            <option value="date_desc">Plus récent</option>
                            <option value="prix_asc">Prix croissant</option>
                            <option value="prix_desc">Prix décroissant</option>
                            <option value="nom_asc">Nom (A-Z)</option>
                            <option value="nom_desc">Nom (Z-A)</option>
                        </select>
                    </div>
                </div>
                
                <!-- Liste des produits -->
                <div id="listeProduits" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($liste->produits->sortBy('pivot.ordre') as $produit)
                        @include('liste-mariage.partials.produit-card', ['produit' => $produit, 'liste' => $liste])
                    @empty
                        <div class="col-span-3 text-center py-10">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4.5L4 7m16 0l-8 4.5M4 7v10l8 4.5m0-14.5v14.5m8-10l-8 4.5m0 0l-8-4.5" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun produit pour le moment</h3>
                            <p class="mt-1 text-sm text-gray-500">Cette liste de mariage ne contient pas encore d'articles.</p>
                            @auth
                                @if(auth()->id() === $liste->user_id)
                                    <div class="mt-6">
                                        <a href="{{ route('liste-mariage.edit', $liste) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                            Ajouter des articles
                                        </a>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Colonne latérale -->
            <div class="mt-8 lg:mt-0 lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Résumé de la liste</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Total des articles</span>
                            <span class="text-sm font-medium">{{ $totalProduits }} articles</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Articles réservés</span>
                            <span class="text-sm font-medium text-green-600">{{ $produitsReserves }} articles</span>
                        </div>
                        
                        <div class="border-t border-gray-200 my-3"></div>
                        
                        <div class="flex justify-between">
                            <span class="text-base font-medium">Progression</span>
                            <span class="text-base font-bold theme-text">{{ $pourcentage }}%</span>
                        </div>
                        
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-amber-500 h-2.5 rounded-full" style="width: {{ $pourcentage }}%"></div>
                        </div>
                        
                        <div class="pt-4">
                            @auth
                                @if(auth()->id() === $liste->user_id)
                                    <a href="{{ route('liste-mariage.edit', $liste) }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                        Modifier la liste
                                    </a>
                                @else
                                    <button type="button" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                        Offrir un cadeau
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                    Se connecter pour participer
                                </a>
                            @endauth
                        </div>
                        
                        @if(auth()->check() && auth()->id() !== $liste->user_id)
                            <div class="mt-3 text-center">
                                <button type="button" class="text-sm text-amber-600 hover:text-amber-800">
                                    <svg class="h-5 w-5 inline-block -mt-1 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    Ajouter à mes favoris
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Message personnalisé -->
                <div class="mt-6 bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Un mot de la part des mariés</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Merci de partager ce moment si spécial avec nous. Votre présence est le plus beau des cadeaux, mais si vous souhaitez nous faire un cadeau, cette liste vous guidera dans vos choix. N'hésitez pas à nous contacter pour toute question !
                    </p>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($liste->user->name) }}&color=FFFFFF&background={{ str_replace('#', '', $liste->couleur_principale) }}" alt="">
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $liste->user->name }}</p>
                                <div class="flex space-x-1 text-sm text-gray-500">
                                    <a href="mailto:{{ $liste->email_contact }}" class="hover:text-amber-600">{{ $liste->email_contact }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'offre de cadeau -->
<div id="modalOffreCadeau" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center pb-3">
            <h3 class="text-xl font-medium text-gray-900">Faire une offre de cadeau</h3>
            <button id="fermerModal" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <div class="mt-4">
            <p class="text-gray-600 mb-4">Vous souhaitez offrir un cadeau aux mariés. Choisissez une option ci-dessous :</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="#" class="border border-gray-200 rounded-lg p-4 hover:border-amber-500 hover:bg-amber-50 transition-colors">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-base font-medium text-gray-900">Carte cadeau</h4>
                            <p class="mt-1 text-sm text-gray-500">Offrez une carte cadeau personnalisée</p>
                        </div>
                    </div>
                </a>
                
                <a href="#" class="border border-gray-200 rounded-lg p-4 hover:border-amber-500 hover:bg-amber-50 transition-colors">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-base font-medium text-gray-900">Participation financière</h4>
                            <p class="mt-1 text-sm text-gray-500">Participez financièrement à leur projet</p>
                        </div>
                    </div>
                </a>
                
                <a href="#" class="border border-gray-200 rounded-lg p-4 hover:border-amber-500 hover:bg-amber-50 transition-colors">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-base font-medium text-gray-900">Article de la liste</h4>
                            <p class="mt-1 text-sm text-gray-500">Choisissez un article dans la liste</p>
                        </div>
                    </div>
                </a>
                
                <a href="#" class="border border-gray-200 rounded-lg p-4 hover:border-amber-500 hover:bg-amber-50 transition-colors">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-base font-medium text-gray-900">Message personnalisé</h4>
                            <p class="mt-1 text-sm text-gray-500">Laissez un message aux mariés</p>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="mt-6 pt-4 border-t border-gray-200">
                <button type="button" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Gestion du menu de partage
    document.addEventListener('DOMContentLoaded', function() {
        const partagerBtn = document.getElementById('partagerBtn');
        const menuPartage = document.getElementById('menuPartage');
        const modalOffreCadeau = document.getElementById('modalOffreCadeau');
        const fermerModal = document.getElementById('fermerModal');
        
        // Afficher/masquer le menu de partage
        partagerBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            menuPartage.classList.toggle('hidden');
        });
        
        // Fermer le menu de partage en cliquant à l'extérieur
        document.addEventListener('click', function() {
            if (!menuPartage.classList.contains('hidden')) {
                menuPartage.classList.add('hidden');
            }
        });
        
        // Empêcher la fermeture lors du clic sur le menu
        menuPartage.addEventListener('click', function(e) {
            e.stopPropagation();
        });
        
        // Gestion du modal d'offre de cadeau
        const btnOffrirCadeau = document.querySelector('button:contains("Offrir un cadeau")');
        if (btnOffrirCadeau) {
            btnOffrirCadeau.addEventListener('click', function() {
                modalOffreCadeau.classList.remove('hidden');
            });
        }
        
        // Fermer le modal
        fermerModal.addEventListener('click', function() {
            modalOffreCadeau.classList.add('hidden');
        });
        
        // Fermer le modal en cliquant à l'extérieur
        window.addEventListener('click', function(e) {
            if (e.target === modalOffreCadeau) {
                modalOffreCadeau.classList.add('hidden');
            }
        });
        
        // Fonction pour copier le lien de partage
        window.copierLien = function() {
            const lienPartage = document.getElementById('lienPartage');
            lienPartage.select();
            document.execCommand('copy');
            
            // Afficher une notification
            const notification = document.createElement('div');
            notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg';
            notification.textContent = 'Lien copié dans le presse-papier !';
            document.body.appendChild(notification);
            
            // Supprimer la notification après 3 secondes
            setTimeout(() => {
                notification.remove();
            }, 3000);
        };
        
        // Filtrage des produits
        const rechercheProduit = document.getElementById('rechercheProduit');
        const trierPar = document.getElementById('trierPar');
        const listeProduits = document.getElementById('listeProduits');
        
        if (rechercheProduit) {
            rechercheProduit.addEventListener('input', filtrerProduits);
        }
        
        if (trierPar) {
            trierPar.addEventListener('change', filtrerProduits);
        }
        
        function filtrerProduits() {
            const termeRecherche = rechercheProduit.value.toLowerCase();
            const tri = trierPar.value;
            
            // Implémentez ici la logique de filtrage et de tri des produits
            // Cette partie nécessite généralement une requête AJAX pour récupérer les produits filtrés
            // ou une implémentation côté client si les données sont déjà chargées
            
            console.log('Recherche:', termeRecherche, 'Tri:', tri);
            // À compléter avec la logique de filtrage et de tri
        }
    });
</script>
@endpush
