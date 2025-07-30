<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashback Market - Votre plateforme de cashback préférée</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .feature-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="flex items-center">
                            <img src="{{ asset('storage/logos/hHsWV7BbVyo0PHKgGs0TAfeVhjxWUxSSdVgMKp1K.png') }}" alt="Cashback Market" class="h-10 w-auto">
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('boutiques.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Boutiques</a>
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Connexion</a>
                    <a href="{{ route('register') }}" class="ml-4 bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors">S'inscrire</a>
                </div>
            </div>
        </div>
    </nav>


    <!-- Hero Section -->
    <div class="hero-gradient text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Gagnez du cash sur chaque achat !</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">Cashback immédiat, offres exclusives et réductions jusqu'à 80% chez vos marques préférées</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 mt-10">
                @auth
                <a href="{{ route('cagnotte') }}" class="bg-white text-blue-600 px-8 py-3 rounded-full font-bold hover:bg-blue-50 transition-colors text-lg">
                    <i class="fas fa-wallet mr-2"></i>Voir ma cagnotte
                </a>
                @else
                <a href="{{ route('login') }}" class="bg-white text-blue-600 px-8 py-3 rounded-full font-bold hover:bg-blue-50 transition-colors text-lg">
                    <i class="fas fa-wallet mr-2"></i>Voir ma cagnotte
                </a>
                @endauth
                <a href="#comment-ca-marche" class="bg-blue-700 bg-opacity-50 text-white px-8 py-3 rounded-full font-bold hover:bg-opacity-70 transition-colors text-lg">
                    <i class="fas fa-play-circle mr-2"></i>Voir la démo
                </a>
            </div>
            <div class="mt-12 grid md:grid-cols-4 gap-6 text-left">
                <div class="bg-white bg-opacity-10 p-4 rounded-lg backdrop-blur-sm">
                    <div class="text-3xl font-bold text-yellow-300">+30%</div>
                    <div class="text-sm">Cashback moyen</div>
                </div>
                <div class="bg-white bg-opacity-10 p-4 rounded-lg backdrop-blur-sm">
                    <div class="text-3xl font-bold text-yellow-300">500+</div>
                    <div class="text-sm">Boutiques partenaires</div>
                </div>
                <div class="bg-white bg-opacity-10 p-4 rounded-lg backdrop-blur-sm">
                    <div class="text-3xl font-bold text-yellow-300">24h</div>
                    <div class="text-sm">Paiement express</div>
                </div>
                <div class="bg-white bg-opacity-10 p-4 rounded-lg backdrop-blur-sm">
                    <div class="text-3xl font-bold text-yellow-300">0€</div>
                    <div class="text-sm">Frais de retrait</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fonctionnalités Principales -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Tout ce dont vous avez besoin
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Découvrez comment maximiser vos économies avec nos fonctionnalités exclusives
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Partage de lien -->
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="bg-blue-100 w-14 h-14 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-share-alt text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Parrainez, gagnez</h3>
                    <p class="text-gray-600 mb-4">Partagez votre lien de parrainage et gagnez jusqu'à 20€ par personne qui s'inscrit via votre lien.</p>
                    <a href="{{ route('parrainage') }}" class="text-blue-600 font-medium inline-flex items-center">
                        Obtenir mon lien <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <!-- KDO surprise -->
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="bg-pink-100 w-14 h-14 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-gift text-pink-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">KDO surprise</h3>
                    <p class="text-gray-600 mb-4">Offrez un cadeau surprise à un ami ou un proche et faites-lui plaisir instantanément. Choisissez le montant et envoyez la surprise !</p>
                    @auth
                        <a href="{{ route('kdo') }}" class="text-blue-600 font-medium inline-flex items-center">
                            Offrir un KDO <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-blue-600 font-medium inline-flex items-center">
                            Offrir un KDO <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @endauth
                </div>
                
                <!-- Liste de mariage -->
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="bg-purple-100 w-14 h-14 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-heart text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Liste de mariage</h3>
                    <p class="text-gray-600 mb-4">Créez votre liste de mariage et cumulez du cashback sur tous les cadeaux reçus.</p>
                    @auth
                        <a href="{{ route('liste_mariage') }}" class="text-blue-600 font-medium inline-flex items-center">
                            Créer ma liste <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        <a href="{{ route('liste_mariage') }}" class="text-blue-600 font-medium inline-flex items-center mt-2">
                            Accéder à la liste de mariage <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-blue-600 font-medium inline-flex items-center">
                            Créer ma liste <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        <a href="{{ route('login') }}" class="text-blue-600 font-medium inline-flex items-center mt-2">
                            Accéder à la liste de mariage <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Bannière publicitaire carrée -->
    <div class="bg-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <a href="#" class="block group">
                        <div class="bg-gradient-to-r from-green-600 to-emerald-500 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-white bg-opacity-20 p-3 rounded-lg">
                                        <i class="fas fa-tag text-white text-2xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-bold text-white">Code promo exclusif : <span class="bg-white text-green-700 px-2 py-1 rounded">CASHBACK15</span></h3>
                                        <p class="text-green-100 mt-1">15% de réduction sur votre première commande</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="hidden md:block">
                    <a href="#" class="block h-full">
                        <div class="bg-gray-100 rounded-xl h-full flex items-center justify-center border-2 border-dashed border-gray-300 hover:border-blue-400 transition-colors">
                            <div class="text-center p-4">
                                <i class="fas fa-ad text-gray-400 text-2xl mb-2"></i>
                                <p class="text-sm text-gray-500">Espace publicitaire<br>300x250px</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Affichage intelligent d'une campagne publicitaire -->
    @php
        use App\Models\Campagne;
        $campagne = Campagne::with('ciblages')->where('statut', 'active')->inRandomOrder()->first();
    @endphp
    @if($campagne)
        <div class="max-w-2xl mx-auto my-8">
            <x-campagne-publicitaire :campagne="$campagne" />
        </div>
    @endif

    <!-- Section Boutiques Partenaires -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Nos Boutiques Partenaires
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500">
                    Plus de 1 000 boutiques où économiser avec le cashback
                </p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @php
                    $featuredStores = [
                        [
                            'name' => 'Amazon', 
                            'category' => 'Tout pour vous', 
                            'cashback' => '5%',
                            'color' => 'text-gray-800',
                            'badge' => 'bg-yellow-100 text-yellow-800',
                            'badge_text' => 'Meilleure offre',
                            'rating' => 4.5
                        ],
                        [
                            'name' => 'AliExpress', 
                            'category' => 'Mode & Accessoires', 
                            'cashback' => '8%',
                            'color' => 'text-red-500',
                            'badge' => 'bg-red-100 text-red-800',
                            'badge_text' => 'Nouveau',
                            'rating' => 4.2
                        ],
                        [
                            'name' => 'SHEIN', 
                            'category' => 'Mode & Accessoires', 
                            'cashback' => '12%',
                            'color' => 'text-green-600',
                            'badge' => 'bg-green-100 text-green-800',
                            'badge_text' => 'Populaire',
                            'rating' => 4.0
                        ],
                        [
                            'name' => 'eBay', 
                            'category' => 'High-Tech & Médias', 
                            'cashback' => '3%',
                            'color' => 'text-blue-600',
                            'badge' => 'bg-blue-100 text-blue-800',
                            'badge_text' => 'Meilleur prix',
                            'rating' => 4.3
                        ],
                        [
                            'name' => 'Nike', 
                            'category' => 'Sport & Loisirs', 
                            'cashback' => '6%',
                            'color' => 'text-black',
                            'badge' => 'bg-yellow-100 text-yellow-800',
                            'badge_text' => 'Exclusif',
                            'rating' => 4.7
                        ],
                        [
                            'name' => 'Sephora', 
                            'category' => 'Beauté & Cosmétiques', 
                            'cashback' => '4%',
                            'color' => 'text-pink-600',
                            'badge' => 'bg-pink-100 text-pink-800',
                            'badge_text' => 'Top vente',
                            'rating' => 4.4
                        ]
                    ];
                @endphp
                
                @foreach($featuredStores as $store)
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 transform transition-all hover:scale-105 hover:shadow-lg">
                    <div class="p-4 text-center h-full flex flex-col">
                        <div class="flex-grow flex items-center justify-center mb-3 min-h-[5rem]">
                            <span class="text-2xl font-bold {{ $store['color'] }}">
                                {{ $store['name'] }}
                            </span>
                        </div>
                        <div class="mt-auto">
                            <p class="text-sm text-gray-500 mb-1">{{ $store['category'] }}</p>
                            <p class="text-lg font-bold text-green-600">{{ $store['cashback'] }} de cashback</p>
                            @if(isset($store['rating']))
                            <div class="mt-2 flex items-center justify-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($store['rating']))
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @elseif($i == ceil($store['rating']) && str_contains($store['rating'], '.'))
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <defs>
                                                <linearGradient id="half-{{ $i }}" x1="0" x2="100%" y1="0" y2="0">
                                                    <stop offset="50%" stop-color="currentColor"></stop>
                                                    <stop offset="50%" stop-color="#e5e7eb"></stop>
                                                </linearGradient>
                                            </defs>
                                            <path fill="url(#half-{{ $i }})" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endif
                                @endfor
                                <span class="text-xs text-gray-500 ml-1">({{ $store['rating'] }})</span>
                            </div>
                            @endif
                            @if(isset($store['badge']))
                            <div class="mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $store['badge'] }}">
                                    {{ $store['badge_text'] }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-12 text-center">
                <a href="{{ route('boutiques.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transition-colors shadow-lg">
                    <span>Explorer toutes les boutiques</span>
                    <svg class="ml-3 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Comment ça marche -->
    <div id="comment-ca-marche" class="py-20 bg-gradient-to-b from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block bg-gray-200 text-gray-700 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider mb-4">
                    Fonctionnement
                </span>
                <h2 class="text-4xl font-extrabold text-gray-800 sm:text-5xl mb-4">
                    Comment gagner avec Cashback Market ?
                </h2>
                <div class="w-24 h-1 bg-gray-300 mx-auto mt-6 rounded-full">
                    <div class="w-1/2 h-full bg-gray-600 rounded-full mx-auto"></div>
                </div>
            </div>
            
            <div class="grid md:grid-cols-4 gap-8 relative">
                <!-- Ligne de connexion -->
                <div class="hidden md:block absolute top-16 left-1/4 w-1/2 h-1.5 bg-gray-300 transform -translate-y-1/2 rounded-full">
                    <div class="w-full h-full bg-gradient-to-r from-gray-400 to-gray-300 rounded-full"></div>
                </div>
                
                <!-- Étape 1 -->
                <div class="group relative bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                    <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 w-12 h-12 bg-gradient-to-r from-gray-700 to-gray-800 rounded-full flex items-center justify-center shadow-md">
                        <span class="text-xl font-bold text-white">1</span>
                    </div>
                    <div class="pt-10 text-center">
                        <div class="w-16 h-16 mx-auto mb-5 bg-gray-50 rounded-lg flex items-center justify-center text-gray-700 border border-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Création de compte</h3>
                        <p class="text-sm text-gray-600 mb-3 leading-relaxed">Inscrivez-vous gratuitement et recevez 500 FCFA offerts dès votre inscription.</p>
                        <span class="inline-block px-3 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-full">2 minutes</span>
                    </div>
                </div>
                
                <!-- Étape 2 -->
                <div class="group relative bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                    <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 w-12 h-12 bg-gradient-to-r from-gray-700 to-gray-800 rounded-full flex items-center justify-center shadow-md">
                        <span class="text-xl font-bold text-white">2</span>
                    </div>
                    <div class="pt-10 text-center">
                        <div class="w-16 h-16 mx-auto mb-5 bg-gray-50 rounded-lg flex items-center justify-center text-gray-700 border border-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Achetez en ligne</h3>
                        <p class="text-sm text-gray-600 mb-3 leading-relaxed">Accédez à vos boutiques préférées et faites vos achats normalement.</p>
                        <span class="inline-block px-3 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-full">Paiement sécurisé</span>
                    </div>
                </div>
                
                <!-- Étape 3 -->
                <div class="group relative bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                    <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 w-12 h-12 bg-gradient-to-r from-gray-700 to-gray-800 rounded-full flex items-center justify-center shadow-md">
                        <span class="text-xl font-bold text-white">3</span>
                    </div>
                    <div class="pt-10 text-center">
                        <div class="w-16 h-16 mx-auto mb-5 bg-gray-50 rounded-lg flex items-center justify-center text-gray-700 border border-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Recevez votre argent</h3>
                        <p class="text-sm text-gray-600 mb-3 leading-relaxed">Votre cashback est crédité automatiquement sous 48h et disponible au retrait.</p>
                        <span class="inline-block px-3 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-full">Retrait facile</span>
                    </div>
                </div>

                <!-- Étape 4 - Parrainage -->
                <div class="group relative bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                    <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 w-12 h-12 bg-gradient-to-r from-amber-500 to-amber-600 rounded-full flex items-center justify-center shadow-md">
                        <i class="fas fa-users text-xl text-white"></i>
                    </div>
                    <div class="pt-10 text-center">
                        <div class="w-16 h-16 mx-auto mb-5 bg-amber-50 rounded-lg flex items-center justify-center text-amber-600 border border-amber-100">
                            <i class="fas fa-hand-holding-usd text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Parrainez et gagnez</h3>
                        <p class="text-sm text-gray-600 mb-3 leading-relaxed">Recevez de l'argent sur chaque achat de vos filleuls et maximisez vos gains !</p>
                        <span class="inline-block px-3 py-1 text-xs font-medium text-amber-700 bg-amber-100 rounded-full">Gains illimités</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-16 text-center">
                <div class="inline-flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-lg font-semibold rounded-full hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                        Commencer à économiser
                        <svg class="ml-3 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#" class="inline-flex items-center justify-center px-8 py-4 border border-gray-300 text-gray-700 text-lg font-medium rounded-full hover:bg-gray-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Voir la vidéo
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Offres Spéciales -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Offres Spéciales Cashback
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500">
                    Profitez de cashback exceptionnels chez vos marques préférées
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Cashback Élevé -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 transform transition-all hover:scale-105">
                    <div class="relative">
                        <img class="w-full h-48 object-cover" src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Cashback Élevé">
                        <div class="absolute top-0 left-0 bg-green-600 text-white text-sm font-bold px-4 py-1 rounded-br-lg">
                            JUSQU'À 20% DE CASHBACK
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Cashback Élevé</h3>
                        <p class="text-gray-600 mb-4">Profitez de cashback exceptionnellement élevé sur une sélection de boutiques partenaires.</p>
                        <ul class="space-y-2 text-sm text-gray-600 mb-4">
                            <li class="flex items-start">
                                <svg class="flex-shrink-0 h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>Jusqu'à 20% de cashback</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="flex-shrink-0 h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>Offres limitées dans le temps</span>
                            </li>
                        </ul>
                        <a href="#" class="inline-flex items-center text-blue-600 font-medium hover:text-blue-800">
                            Voir les offres
                            <svg class="ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Nouveaux Partenaires -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 transform transition-all hover:scale-105">
                    <div class="relative">
                        <img class="w-full h-48 object-cover" src="https://images.unsplash.com/photo-1452860606245-08befc0ff44b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Nouveaux Partenaires">
                        <div class="absolute top-0 left-0 bg-blue-600 text-white text-sm font-bold px-4 py-1 rounded-br-lg">
                            NOUVEAUX PARTENAIRES
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Nouveaux Partenaires</h3>
                        <p class="text-gray-600 mb-4">Découvrez nos dernières boutiques partenaires et profitez d'offres de bienvenue exclusives.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>+10 nouvelles boutiques ce mois-ci</span>
                        </div>
                        <a href="#" class="inline-flex items-center text-blue-600 font-medium hover:text-blue-800">
                            Découvrir les boutiques
                            <svg class="ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Cashback Doublé -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 transform transition-all hover:scale-105">
                    <div class="relative">
                        <img class="w-full h-48 object-cover" src="https://images.unsplash.com/photo 1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Cashback Doublé">
                        <div class="absolute top-0 left-0 bg-purple-600 text-white text-sm font-bold px-4 py-1 rounded-br-lg">
                            CASHBACK DOUBLÉ
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Cashback Doublé</h3>
                        <p class="text-gray-600 mb-4">Profitez du cashback doublé pendant une durée limitée sur nos boutiques partenaires sélectionnées.</p>
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Offre valable jusqu'au 31/12/2024. Voir conditions en magasin.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="inline-flex items-center text-blue-600 font-medium hover:text-blue-800">
                            Voir les conditions
                            <svg class="ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 text-center">
                <a href="{{ route('boutiques.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                    Voir toutes les offres
                    <svg class="ml-3 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Section Parrainage -->
    <div class="py-16 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-extrabold sm:text-5xl mb-4">
                    Programme de Parrainage
                </h2>
                <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                    Parrainez vos amis et gagnez de l'argent sur tous leurs achats !
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Carte 1 -->
                <div class="bg-white rounded-xl shadow-xl overflow-hidden transform transition-all hover:scale-105">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-user-plus text-blue-600 text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Parrainez vos amis</h3>
                        </div>
                        <p class="text-gray-600 mb-6">Partagez votre lien de parrainage et gagnez jusqu'à 20€ par personne qui s'inscrit via votre lien.</p>
                        <div class="bg-blue-50 p-4 rounded-lg mb-6">
                            <p class="text-sm text-blue-700 font-medium">Votre lien de parrainage :</p>
                            <div class="flex mt-2">
                                <input type="text" readonly value="{{ config('app.url') }}/register?ref={{ auth()->check() ? auth()->user()->id : 'votrepseudo' }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md text-sm">
                                <button type="button" onclick="copyToClipboard(this)" class="bg-blue-600 text-white px-4 rounded-r-md hover:bg-blue-700 transition-colors">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">500 FCFA offerts à chaque ami qui s'inscrit via votre lien</p>
                        </div>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center w-full px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700">
                            <i class="fas fa-user-plus mr-2"></i>Créer un compte
                        </a>
                    </div>
                </div>

                <!-- Carte 2 -->
                <div class="bg-white rounded-xl shadow-xl overflow-hidden transform transition-all hover:scale-105">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 p-3 rounded-full mr-4">
                                <i class="fas fa-coins text-green-600 text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Gagnez sur leurs achats</h3>
                        </div>
                        <p class="text-gray-600 mb-6">Recevez 10% du cashback généré par vos filleuls à vie. Plus vous parrainez, plus vous gagnez !</p>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">Bonus d'inscription</span>
                                <span class="font-bold text-green-600">500 FCFA</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">Cashback sur leurs achats</span>
                                <span class="font-bold text-green-600">10% supplémentaire</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">Sans limite</span>
                                <span class="font-bold text-green-600">Gains illimités</span>
                            </div>
                        </div>
                        
                        <a href="#" class="inline-flex items-center justify-center w-full px-6 py-3 bg-green-600 text-white font-medium rounded-md hover:bg-green-700">
                            <i class="fas fa-chart-line mr-2"></i>Voir mes gains
                        </a>
                    </div>
                </div>
            </div>

            <!-- Témoignages -->
            <div class="mt-16 grid md:grid-cols-3 gap-8">
                <div class="bg-white bg-opacity-10 p-6 rounded-xl backdrop-blur-sm">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Marie D." class="w-12 h-12 rounded-full border-2 border-white">
                        <div class="ml-4">
                            <h4 class="font-bold">Marie D.</h4>
                            <p class="text-sm text-blue-100">Membre depuis 6 mois</p>
                        </div>
                    </div>
                    <p class="text-blue-50">"J'ai déjà gagné plus de 200€ en parrainant mes amis. C'est vraiment simple et ça rapporte !"</p>
                </div>
                <div class="bg-white bg-opacity-10 p-6 rounded-xl backdrop-blur-sm">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Thomas L." class="w-12 h-12 rounded-full border-2 border-white">
                        <div class="ml-4">
                            <h4 class="font-bold">Thomas L.</h4>
                            <p class="text-sm text-blue-100">Top parrain du mois</p>
                        </div>
                    </div>
                    <p class="text-blue-50">"Avec 35 parrainés, je touche des revenus passifs chaque mois. Une vraie aubaine !"</p>
                </div>
                <div class="bg-white bg-opacity-10 p-6 rounded-xl backdrop-blur-sm">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Sophie M." class="w-12 h-12 rounded-full border-2 border-white">
                        <div class="ml-4">
                            <h4 class="font-bold">Sophie M.</h4>
                            <p class="text-sm text-blue-100">Membre depuis 1 an</p>
                        </div>
                    </div>
                    <p class="text-blue-50">"J'utilise l'argent gagné pour mes courses. C'est comme une réduction permanente !"</p>
                </div>
            </div>

            <!-- CTA -->
            <div class="mt-16 text-center">
                <h3 class="text-2xl font-bold mb-4">Prêt à commencer à gagner de l'argent ?</h3>
                <p class="text-xl text-blue-100 mb-8">Rejoignez-nous dès maintenant et profitez de tous les avantages</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-yellow-400 text-blue-900 font-bold rounded-full hover:bg-yellow-300 transition-colors">
                        S'inscrire gratuitement
                    </a>
                    <a href="#" class="px-8 py-4 border-2 border-white text-white font-bold rounded-full hover:bg-white hover:bg-opacity-10 transition-colors">
                        En savoir plus
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Produits Populaires -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Produits populaires
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Découvrez nos meilleures offres du moment
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($produitsPopulaires as $produit)
                <a href="{{ route('produits.show', $produit) }}" class="group block bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="relative">
                        <img src="{{ $produit->image ?? 'https://via.placeholder.com/300x200' }}" alt="{{ $produit->nom }}" class="w-full h-48 object-cover">
                        @if($produit->en_promotion && $produit->prix_original > $produit->prix)
                        <div class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                            -{{ round((($produit->prix_original - $produit->prix) / $produit->prix_original) * 100) }}%
                        </div>
                        @endif
                        @if($produit->cashback > 0)
                        <div class="absolute bottom-2 left-2 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                            {{ $produit->cashback }}% cashback
                        </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-medium text-gray-900 group-hover:text-blue-600 transition-colors">
                            {{ $produit->nom }}
                        </h3>
                        <div class="mt-2">
                            <span class="text-lg font-bold text-gray-900">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span>
                            @if($produit->en_promotion && $produit->prix_original > $produit->prix)
                            <span class="ml-2 text-sm text-gray-500 line-through">{{ number_format($produit->prix_original, 0, ',', ' ') }} FCFA</span>
                            @endif
                        </div>
                        @if($produit->boutique)
                        <div class="mt-2 text-sm text-gray-600">
                            <i class="fas fa-store"></i> {{ $produit->boutique->nom }}
                        </div>
                        @endif
                    </div>
                </a>
                @empty
                <p class="col-span-4 text-center text-gray-500">Aucun produit populaire pour le moment.</p>
                @endforelse
            </div>
            
            <div class="mt-12 text-center">
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                    <span>Voir tous les produits</span>
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <script>
    function copyToClipboard(button) {
        const input = button.parentElement.querySelector('input');
        input.select();
        document.execCommand('copy');
        
        const originalIcon = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i>';
        button.classList.add('bg-green-600', 'hover:bg-green-700');
        
        setTimeout(() => {
            button.innerHTML = originalIcon;
            button.classList.remove('bg-green-600', 'hover:bg-green-700');
            button.classList.add('bg-blue-600', 'hover:bg-blue-700');
        }, 2000);
    }
    </script>

    <!-- Bannière publicitaire pleine largeur -->
    <div class="bg-gradient-to-r from-blue-900 to-blue-700 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-white mb-4">Devenez partenaire de Cashback Market</h3>
                <p class="text-blue-100 mb-6 max-w-3xl mx-auto">Augmentez votre visibilité et attirez de nouveaux clients avec nos solutions publicitaires personnalisées.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50">
                        En savoir plus
                    </a>
                    <a href="#" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 bg-opacity-60 hover:bg-opacity-70">
                        Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Boutiques Tendance -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Boutiques Tendance
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Découvrez nos boutiques partenaires les plus populaires
                </p>
            </div>
            
            @if(isset($boutiquesTendances) && $boutiquesTendances->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                    @foreach($boutiquesTendances as $boutique)
                        <a href="{{ route('boutiques.show', $boutique) }}" class="group block bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                            <div class="h-16 flex items-center justify-center mb-2">
                                @if($boutique->logo)
                                    <img src="{{ asset('storage/' . $boutique->logo) }}" alt="{{ $boutique->nom }}" class="h-12 object-contain max-w-full">
                                @else
                                    <i class="fas fa-store text-3xl text-gray-700"></i>
                                @endif
                            </div>
                            <h4 class="font-medium text-gray-900 group-hover:text-blue-600">{{ $boutique->nom }}</h4>
                            @if($boutique->cashback_moyen > 0)
                                <span class="text-sm text-blue-600 font-medium">Jusqu'à {{ number_format($boutique->cashback_moyen, 1) }}%</span>
                            @endif
                            @if($boutique->produits_count > 0)
                                <div class="mt-1 text-xs text-gray-500">{{ $boutique->produits_count }} produits</div>
                            @endif
                        </a>
                    @endforeach
                </div>
                
                <div class="mt-10 text-center">
                    <a href="{{ route('boutiques.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                        Voir toutes les boutiques
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            @else
                <div class="text-center py-10">
                    <p class="text-gray-500">Aucune boutique tendance pour le moment.</p>
                </div>
            @endif
        </div>
    </div>

                    </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h4 class="text-lg font-semibold mb-4">Cashback Market</h4>
                    <p class="text-gray-400">La meilleure façon d'économiser sur vos achats en ligne.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Liens rapides</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Accueil</a></li>
                        <li><a href="#how-it-works" class="text-gray-400 hover:text-white">Comment ça marche</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Boutiques</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Légal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Conditions d'utilisation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Politique de confidentialité</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Mentions légales</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center"><i class="fas fa-envelope mr-2"></i> contact@cashbackmarket.com</li>
                        <li class="flex items-center"><i class="fas fa-phone-alt mr-2"></i> +33 1 23 45 67 89</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Cashback Market. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
</html>
