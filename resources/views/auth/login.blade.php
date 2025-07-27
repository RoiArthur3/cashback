<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Cashback Market</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .bg-auth {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }
        .btn-primary {
            background-color: #2563eb;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Left side - Image/Illustration -->
        <div class="bg-auth hidden md:flex md:w-1/2 p-12 text-white">
            <div class="max-w-md m-auto">
                <h1 class="text-4xl font-bold mb-6">Bienvenue sur Cashback Market</h1>
                <p class="text-xl mb-8">Connectez-vous pour accéder à votre espace personnel et profiter de vos avantages cashback.</p>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="bg-white bg-opacity-20 p-2 rounded-full mr-3">
                            <i class="fas fa-piggy-bank text-white text-xl"></i>
                        </div>
                        <span>Jusqu'à 15% de cashback</span>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-white bg-opacity-20 p-2 rounded-full mr-3">
                            <i class="fas fa-tag text-white text-xl"></i>
                        </div>
                        <span>Des centaines de boutiques partenaires</span>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-white bg-opacity-20 p-2 rounded-full mr-3">
                            <i class="fas fa-shield-alt text-white text-xl"></i>
                        </div>
                        <span>Paiement sécurisé</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right side - Login Form -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <a href="{{ url('/') }}" class="inline-block">
                        <span class="text-3xl font-bold text-blue-600">Cashback<span class="text-blue-400">Market</span></span>
                    </a>
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                        Connectez-vous à votre compte
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Ou 
                        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            inscrivez-vous gratuitement
                        </a>
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                    @csrf
                    <div class="rounded-md shadow-sm space-y-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" autocomplete="email" required 
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-500 @enderror"
                                       value="{{ old('email') }}" autofocus>
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" autocomplete="current-password" required 
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('password') border-red-500 @enderror">
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                                Se souvenir de moi
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500">
                                    Mot de passe oublié ?
                                </a>
                            </div>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Se connecter
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Ou continuez avec</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <div>
                            <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Se connecter avec Google</span>
                                <i class="fab fa-google text-red-500"></i>
                            </a>
                        </div>
                        <div>
                            <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Se connecter avec Facebook</span>
                                <i class="fab fa-facebook text-blue-600"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-8 text-center text-sm text-gray-600">
                    <p>Vous n'avez pas encore de compte ?</p>
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Créer un compte
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
